<?php

/**
 * Converts the MySQL DB dump used by this project into SQLite-compatible statements.
 */
class SqliteSchemaConverter
{
    public static function convertMySqlDump($sql)
    {
        $statements = self::splitStatements($sql);
        $meta = self::collectAlterMetadata($statements);
        $sqliteStatements = array();

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if ($statement === '') {
                continue;
            }

            if (stripos($statement, 'CREATE TABLE') === 0) {
                $converted = self::convertCreateTable($statement, $meta);
                if ($converted) {
                    $sqliteStatements[] = $converted;
                }
                continue;
            }

            if (stripos($statement, 'INSERT INTO') === 0) {
                $sqliteStatements[] = self::convertInsertStatement($statement);
                continue;
            }
        }

        return $sqliteStatements;
    }

    protected static function collectAlterMetadata(array $statements)
    {
        $primaryKeys = array();
        $autoIncrements = array();

        foreach ($statements as $statement) {
            if (stripos($statement, 'ALTER TABLE') !== 0) {
                continue;
            }

            if (!preg_match('/^ALTER TABLE\s+`?([^`\s]+)`?/i', $statement, $tableMatch)) {
                continue;
            }

            $table = $tableMatch[1];

            if (preg_match_all('/ADD\s+PRIMARY\s+KEY\s*\(([^)]+)\)/i', $statement, $pkMatches)) {
                $columns = self::parseColumnList(end($pkMatches[1]));
                if ($columns) {
                    $primaryKeys[$table] = $columns;
                }
            }

            if (preg_match_all('/MODIFY\s+`([^`]+)`[^;]*?AUTO_INCREMENT(?:\s*,\s*AUTO_INCREMENT\s*=\s*(\d+))?/i', $statement, $autoMatches, PREG_SET_ORDER)) {
                foreach ($autoMatches as $match) {
                    $autoIncrements[$table] = array(
                        'column' => $match[1]
                    );
                }
            }
        }

        return array(
            'primaryKeys' => $primaryKeys,
            'autoIncrements' => $autoIncrements
        );
    }

    protected static function convertCreateTable($statement, array $meta)
    {
        if (!preg_match('/^CREATE TABLE\s+`?([^`( ]+)`?/i', $statement, $tableMatch)) {
            return null;
        }

        $table = $tableMatch[1];
        $openPos = strpos($statement, '(');
        $closePos = strrpos($statement, ')');
        if ($openPos === false || $closePos === false || $closePos <= $openPos) {
            return null;
        }

        $body = substr($statement, $openPos + 1, $closePos - $openPos - 1);
        $lines = preg_split('/\r\n|\r|\n/', $body);

        $definitions = array();
        $autoIncrementColumn = isset($meta['autoIncrements'][$table]['column']) ? $meta['autoIncrements'][$table]['column'] : null;
        $autoPrimaryKeyApplied = false;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $line = rtrim($line, ',');
            if ($line === '') {
                continue;
            }

            if ($line[0] !== '`') {
                continue;
            }

            if (!preg_match('/^`([^`]+)`\s+(.+)$/s', $line, $columnMatch)) {
                continue;
            }

            $column = $columnMatch[1];
            $definition = self::normalizeColumnDefinition($columnMatch[2]);

            if ($autoIncrementColumn && $column === $autoIncrementColumn) {
                $definitions[] = '  `' . $column . '` INTEGER PRIMARY KEY AUTOINCREMENT';
                $autoPrimaryKeyApplied = true;
                continue;
            }

            $definitions[] = '  `' . $column . '` ' . $definition;
        }

        $primaryKeys = isset($meta['primaryKeys'][$table]) ? $meta['primaryKeys'][$table] : array();
        if (!$autoPrimaryKeyApplied && $primaryKeys) {
            $definitions[] = '  PRIMARY KEY (`' . implode('`, `', $primaryKeys) . '`)';
        }

        return "CREATE TABLE `" . $table . "` (\n" . implode(",\n", $definitions) . "\n);";
    }

    protected static function normalizeColumnDefinition($definition)
    {
        $definition = preg_replace('/\s+unsigned\b/i', '', $definition);
        $definition = preg_replace('/\s+CHARACTER SET\s+\w+/i', '', $definition);
        $definition = preg_replace('/\s+COLLATE\s+\w+/i', '', $definition);
        $definition = preg_replace('/\s+AUTO_INCREMENT\b/i', '', $definition);
        $definition = preg_replace('/\s+ON UPDATE CURRENT_TIMESTAMP\b/i', '', $definition);
        $definition = preg_replace('/\s+COMMENT\s+\'(?:\\\\\'|[^\'])*\'/i', '', $definition);

        $definition = preg_replace('/\bTINYINT\(\d+\)/i', 'INTEGER', $definition);
        $definition = preg_replace('/\bSMALLINT\(\d+\)/i', 'INTEGER', $definition);
        $definition = preg_replace('/\bMEDIUMINT\(\d+\)/i', 'INTEGER', $definition);
        $definition = preg_replace('/\bBIGINT\(\d+\)/i', 'INTEGER', $definition);
        $definition = preg_replace('/\bINT\(\d+\)/i', 'INTEGER', $definition);
        $definition = preg_replace('/\bDECIMAL\([^)]+\)/i', 'REAL', $definition);
        $definition = preg_replace('/\bDOUBLE\b/i', 'REAL', $definition);
        $definition = preg_replace('/\bFLOAT\b/i', 'REAL', $definition);
        $definition = preg_replace('/\bVARCHAR\(\d+\)/i', 'TEXT', $definition);
        $definition = preg_replace('/\bCHAR\(\d+\)/i', 'TEXT', $definition);
        $definition = preg_replace('/\bTINYTEXT\b/i', 'TEXT', $definition);
        $definition = preg_replace('/\bMEDIUMTEXT\b/i', 'TEXT', $definition);
        $definition = preg_replace('/\bLONGTEXT\b/i', 'TEXT', $definition);
        $definition = preg_replace('/\bTIMESTAMP\b/i', 'TEXT', $definition);
        $definition = preg_replace('/\bDATETIME\b/i', 'TEXT', $definition);
        $definition = preg_replace('/\bENUM\([^)]+\)/i', 'TEXT', $definition);

        $definition = preg_replace('/\s+/', ' ', trim($definition));

        // MySQL non-strict mode provides implicit defaults for NOT NULL columns.
        // Add them explicitly so SQLite behaves the same way.
        if (preg_match('/\bNOT NULL\b/i', $definition) && !preg_match('/\bDEFAULT\b/i', $definition)) {
            if (preg_match('/^(INTEGER|REAL)\b/i', $definition)) {
                $definition .= " DEFAULT 0";
            } elseif (preg_match('/^TEXT\b/i', $definition)) {
                $definition .= " DEFAULT ''";
            }
        }

        return $definition;
    }

    protected static function parseColumnList($columnsSql)
    {
        $columns = array();
        if (preg_match_all('/`([^`]+)`/', $columnsSql, $matches)) {
            foreach ($matches[1] as $column) {
                $columns[] = $column;
            }
            return $columns;
        }

        $raw = explode(',', $columnsSql);
        foreach ($raw as $column) {
            $column = trim($column, " \t\n\r\0\x0B`");
            if ($column !== '') {
                $columns[] = $column;
            }
        }

        return $columns;
    }

    protected static function convertInsertStatement($statement)
    {
        $statement = rtrim($statement, ';');
        $output = '';
        $inSingle = false;
        $length = strlen($statement);

        for ($i = 0; $i < $length; $i++) {
            $char = $statement[$i];

            if ($char === "'") {
                $inSingle = !$inSingle;
                $output .= $char;
                continue;
            }

            if ($inSingle && $char === '\\' && isset($statement[$i + 1])) {
                $next = $statement[$i + 1];
                // Convert MySQL backslash escapes to SQLite equivalents.
                // SQLite does not support backslash escapes in strings.
                switch ($next) {
                    case "'":
                        $output .= "''";
                        $i++;
                        continue 2;
                    case '\\':
                        $output .= '\\';
                        $i++;
                        continue 2;
                    case 'n':
                        $output .= "\n";
                        $i++;
                        continue 2;
                    case 'r':
                        $output .= "\r";
                        $i++;
                        continue 2;
                    case 't':
                        $output .= "\t";
                        $i++;
                        continue 2;
                    case '0':
                        $i++;
                        continue 2;
                }
            }

            $output .= $char;
        }

        return $output . ';';
    }

    protected static function splitStatements($sql)
    {
        $statements = array();
        $buffer = '';
        $inSingle = false;
        $inDouble = false;
        $escaped = false;

        $length = strlen($sql);
        for ($i = 0; $i < $length; $i++) {
            $char = $sql[$i];

            if ($escaped) {
                $buffer .= $char;
                $escaped = false;
                continue;
            }

            if (($inSingle || $inDouble) && $char === '\\') {
                $buffer .= $char;
                $escaped = true;
                continue;
            }

            if (!$inDouble && $char === "'") {
                $inSingle = !$inSingle;
                $buffer .= $char;
                continue;
            }

            if (!$inSingle && $char === '"') {
                $inDouble = !$inDouble;
                $buffer .= $char;
                continue;
            }

            if (!$inSingle && !$inDouble && $char === ';') {
                $statement = trim($buffer);
                if ($statement !== '') {
                    $statements[] = $statement;
                }
                $buffer = '';
                continue;
            }

            $buffer .= $char;
        }

        $statement = trim($buffer);
        if ($statement !== '') {
            $statements[] = $statement;
        }

        return $statements;
    }
}
