<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/SqliteSchemaConverter.php';

final class SqliteSchemaConverterTest extends TestCase
{
    public function testConvertsMySqlDumpToSqliteStatements(): void
    {
        $sql = file_get_contents(__DIR__ . '/../includes/install/DB.sql');
        $statements = SqliteSchemaConverter::convertMySqlDump($sql);

        $this->assertNotEmpty($statements);

        $creates = 0;
        $inserts = 0;
        foreach ($statements as $s) {
            if (stripos($s, 'CREATE TABLE') === 0) $creates++;
            if (stripos($s, 'INSERT INTO') === 0) $inserts++;
        }

        $this->assertSame(100, $creates, 'Should produce 100 CREATE TABLE statements');
        $this->assertGreaterThan(0, $inserts, 'Should produce INSERT statements');
    }

    public function testAllStatementsExecuteWithoutError(): void
    {
        $sql = file_get_contents(__DIR__ . '/../includes/install/DB.sql');
        $statements = SqliteSchemaConverter::convertMySqlDump($sql);

        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($statements as $i => $stmt) {
            try {
                $pdo->exec($stmt);
            } catch (Exception $e) {
                $this->fail("Statement #$i failed: " . $e->getMessage() . "\nSQL: " . substr($stmt, 0, 200));
            }
        }

        // Verify table count
        $tables = $pdo->query("SELECT count(*) FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchColumn();
        $this->assertSame(100, (int) $tables);
    }

    public function testTypeNormalization(): void
    {
        $mysql = <<<'SQL'
CREATE TABLE `test_types` (
  `id` int(11) NOT NULL,
  `small` smallint(6) NOT NULL DEFAULT '0',
  `tiny` tinyint(1) NOT NULL DEFAULT '0',
  `big` bigint(20) NOT NULL DEFAULT '0',
  `medium` mediumint(8) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `code` char(10) DEFAULT NULL,
  `body` longtext,
  `summary` mediumtext,
  `note` tinytext,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ratio` double NOT NULL DEFAULT '0',
  `score` float NOT NULL DEFAULT '0',
  `status` enum('active','inactive') DEFAULT 'active',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `test_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `test_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL;

        $statements = SqliteSchemaConverter::convertMySqlDump($mysql);
        $this->assertCount(1, $statements);

        $create = $statements[0];

        // Auto-increment column
        $this->assertStringContainsString('`id` INTEGER PRIMARY KEY AUTOINCREMENT', $create);
        // Integer types
        $this->assertStringContainsString('`small` INTEGER', $create);
        $this->assertStringContainsString('`tiny` INTEGER', $create);
        $this->assertStringContainsString('`big` INTEGER', $create);
        $this->assertStringContainsString('`medium` INTEGER', $create);
        // Text types
        $this->assertStringContainsString('`name` TEXT', $create);
        $this->assertStringContainsString('`code` TEXT', $create);
        $this->assertStringContainsString('`body` TEXT', $create);
        $this->assertStringContainsString('`summary` TEXT', $create);
        $this->assertStringContainsString('`note` TEXT', $create);
        // Real types
        $this->assertStringContainsString('`price` REAL', $create);
        $this->assertStringContainsString('`ratio` REAL', $create);
        $this->assertStringContainsString('`score` REAL', $create);
        // Enum → TEXT
        $this->assertStringContainsString('`status` TEXT', $create);
        // Timestamp / Datetime → TEXT
        $this->assertStringContainsString('`created` TEXT', $create);
        $this->assertStringContainsString('`updated` TEXT', $create);
        // No MySQL-isms
        $this->assertStringNotContainsString('ENGINE=', $create);
        $this->assertStringNotContainsString('unsigned', strtolower($create));
        $this->assertStringNotContainsString('AUTO_INCREMENT', $create);

        // Verify it executes
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec($create);
    }

    public function testNotNullColumnsGetImplicitDefaults(): void
    {
        $mysql = <<<'SQL'
CREATE TABLE `defaults_test` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `score` int(11) NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `has_default` int(11) NOT NULL DEFAULT '5',
  `nullable` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `defaults_test`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `defaults_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL;

        $statements = SqliteSchemaConverter::convertMySqlDump($mysql);
        $create = $statements[0];

        // NOT NULL without DEFAULT should get one
        $this->assertMatchesRegularExpression('/`name` TEXT NOT NULL DEFAULT \'\'/', $create);
        $this->assertMatchesRegularExpression('/`score` INTEGER NOT NULL DEFAULT 0/', $create);
        $this->assertMatchesRegularExpression('/`rate` REAL NOT NULL DEFAULT 0/', $create);
        // Existing DEFAULT should be preserved (not doubled)
        $this->assertStringContainsString("`has_default` INTEGER NOT NULL DEFAULT '5'", $create);
        // Nullable columns should NOT get a default added
        $this->assertStringContainsString('`nullable` TEXT DEFAULT NULL', $create);

        // Verify it works: insert without providing NOT NULL cols
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec($create);
        $pdo->exec("INSERT INTO `defaults_test` (`has_default`) VALUES (1)");
        $row = $pdo->query("SELECT * FROM defaults_test WHERE rowid = 1")->fetch(PDO::FETCH_ASSOC);
        $this->assertSame('', $row['name']);
        $this->assertEquals(0, $row['score']);
    }

    public function testInsertEscapeSequences(): void
    {
        $mysql = <<<'SQL'
CREATE TABLE `esc_test` (
  `id` int(11) NOT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `esc_test`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `esc_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `esc_test` (`id`, `content`) VALUES
(1, 'line1\nline2'),
(2, 'tab\there'),
(3, 'back\\slash'),
(4, 'it\'s fine'),
(5, 'cr\r\nnewline');
SQL;

        $statements = SqliteSchemaConverter::convertMySqlDump($mysql);

        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        foreach ($statements as $stmt) {
            $pdo->exec($stmt);
        }

        $rows = $pdo->query("SELECT * FROM esc_test ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);

        $this->assertSame("line1\nline2", $rows[0]['content'], 'backslash-n should become real newline');
        $this->assertSame("tab\there", $rows[1]['content'], 'backslash-t should become real tab');
        $this->assertSame('back\\slash', $rows[2]['content'], 'double backslash should become single');
        $this->assertSame("it's fine", $rows[3]['content'], 'escaped quote should become literal quote');
        $this->assertSame("cr\r\nnewline", $rows[4]['content'], 'backslash-r-n should become CR+LF');
    }

    public function testMySqlAttributesStripped(): void
    {
        $mysql = <<<'SQL'
CREATE TABLE `attrs_test` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` varchar(200) NOT NULL COMMENT 'a user note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `attrs_test`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `attrs_test`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
SQL;

        $statements = SqliteSchemaConverter::convertMySqlDump($mysql);
        $create = $statements[0];

        $this->assertStringNotContainsString('unsigned', strtolower($create));
        $this->assertStringNotContainsString('CHARACTER SET', $create);
        $this->assertStringNotContainsString('COLLATE', $create);
        $this->assertStringNotContainsString('ON UPDATE', $create);
        $this->assertStringNotContainsString('COMMENT', $create);
        $this->assertStringNotContainsString('ENGINE=', $create);

        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec($create);
    }

    public function testCompositePrimaryKey(): void
    {
        $mysql = <<<'SQL'
CREATE TABLE `composite_pk` (
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `composite_pk`
  ADD PRIMARY KEY (`user_id`, `item_id`);
SQL;

        $statements = SqliteSchemaConverter::convertMySqlDump($mysql);
        $create = $statements[0];

        $this->assertStringContainsString('PRIMARY KEY (`user_id`, `item_id`)', $create);

        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec($create);

        $pdo->exec("INSERT INTO composite_pk (user_id, item_id) VALUES (1, 1)");
        $pdo->exec("INSERT INTO composite_pk (user_id, item_id) VALUES (1, 2)");

        // Duplicate key should fail
        $this->expectException(PDOException::class);
        $pdo->exec("INSERT INTO composite_pk (user_id, item_id) VALUES (1, 1)");
    }
}
