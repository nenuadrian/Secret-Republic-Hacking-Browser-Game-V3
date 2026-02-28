<?php

/**
 * Lightweight SQLite adapter that mirrors the Mysqlidb methods used by this project.
 */
class SqliteDb
{
    public $trace = array();
    public $pageLimit = 20;

    protected $pdo;
    protected $traceEnabled = false;
    protected $lastError = '';

    protected $wheres = array();
    protected $joins = array();
    protected $orderBys = array();
    protected $groupBys = array();

    public function __construct($path)
    {
        if (!$path) {
            throw new InvalidArgumentException('SQLite path must be provided');
        }

        if ($path[0] !== '/' && defined('ABSPATH')) {
            $path = ABSPATH . ltrim($path, '/');
        }

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $this->pdo = new PDO('sqlite:' . $path);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->exec('PRAGMA foreign_keys = ON');
    }

    public function setTrace($enabled)
    {
        $this->traceEnabled = (bool) $enabled;
        return $this;
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    public function where($field)
    {
        $args = func_get_args();
        $argc = count($args);

        if ($argc === 1) {
            $this->addWhere($field, array());
            return $this;
        }

        $value = $args[1];
        $operator = $argc >= 3 ? $args[2] : '=';

        if (is_array($value)) {
            if ($this->hasPlaceholders($field)) {
                $this->addWhere($field, array_values($value));
                return $this;
            }

            if ($this->isAssociativeArray($value)) {
                foreach ($value as $op => $val) {
                    $this->addFieldCondition($field, $op, $val);
                }
                return $this;
            }

            $op = strtoupper(trim((string) $operator));
            if ($op === '' || $op === '=') {
                $op = 'IN';
            }
            $this->addFieldCondition($field, $op, $value);
            return $this;
        }

        if ($this->hasPlaceholders($field)) {
            $this->addWhere($field, array($value));
            return $this;
        }

        $this->addFieldCondition($field, $operator, $value);
        return $this;
    }

    public function join($table, $condition, $type = '')
    {
        $joinType = strtoupper(trim($type));
        if ($joinType === '') {
            $joinType = 'INNER';
        }
        if (substr($joinType, -4) !== 'JOIN') {
            $joinType .= ' JOIN';
        }

        $this->joins[] = $joinType . ' ' . $table . ' ON ' . $condition;
        return $this;
    }

    public function orderBy($field, $direction = null)
    {
        $field = $this->translateSqlFunctions($field);
        if ($direction === null || $direction === '') {
            $this->orderBys[] = $field;
            return $this;
        }

        $dir = strtoupper(trim((string) $direction));
        if ($dir === 'ASC' || $dir === 'DESC') {
            $this->orderBys[] = $field . ' ' . $dir;
        } else {
            $this->orderBys[] = $field;
        }

        return $this;
    }

    public function groupBy($field)
    {
        $this->groupBys[] = $field;
        return $this;
    }

    public function get($table, $limit = null, $columns = '*')
    {
        $params = array();
        $sql = 'SELECT ' . $columns . ' FROM ' . $table
            . $this->buildJoinClause()
            . $this->buildWhereClause($params)
            . $this->buildGroupByClause()
            . $this->buildOrderByClause()
            . $this->buildLimitClause($limit);

        try {
            return $this->executeSelect($sql, $params);
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return array();
        } finally {
            $this->resetQueryState();
        }
    }

    public function getOne($table, $columns = '*')
    {
        $results = $this->get($table, 1, $columns);
        return isset($results[0]) ? $results[0] : array();
    }

    public function paginate($table, $page, $columns = '*')
    {
        $page = max(1, (int) $page);
        $limit = max(1, (int) $this->pageLimit);
        $offset = ($page - 1) * $limit;

        $params = array();
        $sql = 'SELECT ' . $columns . ' FROM ' . $table
            . $this->buildJoinClause()
            . $this->buildWhereClause($params)
            . $this->buildGroupByClause()
            . $this->buildOrderByClause()
            . ' LIMIT ' . $limit . ' OFFSET ' . $offset;

        try {
            return $this->executeSelect($sql, $params);
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return array();
        } finally {
            $this->resetQueryState();
        }
    }

    public function insert($table, $insertData)
    {
        if (!is_array($insertData) || !$insertData) {
            $this->lastError = 'Invalid insert payload';
            return false;
        }

        $columns = array_keys($insertData);
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', $columns),
            $placeholders
        );

        try {
            $this->executeNonSelect($sql, array_values($insertData));
            $id = (int) $this->pdo->lastInsertId();
            return $id > 0 ? $id : true;
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        } finally {
            $this->resetQueryState();
        }
    }

    public function update($table, $updateData, $limit = null)
    {
        if (!is_array($updateData) || !$updateData) {
            $this->lastError = 'Invalid update payload';
            return false;
        }

        $set = array();
        $setParams = array();
        foreach ($updateData as $column => $value) {
            $set[] = $column . ' = ?';
            $setParams[] = $value;
        }

        $whereParams = array();
        $whereClause = $this->buildWhereClause($whereParams);
        $orderClause = $this->buildOrderByClause();
        $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $set);
        $params = array_merge($setParams, $whereParams);

        $limit = is_numeric($limit) ? max(0, (int) $limit) : 0;
        if ($limit > 0) {
            $sql .= ' WHERE rowid IN (SELECT rowid FROM ' . $table
                . $whereClause . $orderClause . ' LIMIT ' . $limit . ')';
        } else {
            $sql .= $whereClause;
        }

        try {
            $this->executeNonSelect($sql, $params);
            return true;
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        } finally {
            $this->resetQueryState();
        }
    }

    public function delete($table, $limit = null)
    {
        $whereParams = array();
        $whereClause = $this->buildWhereClause($whereParams);
        $orderClause = $this->buildOrderByClause();
        $sql = 'DELETE FROM ' . $table;

        $limit = is_numeric($limit) ? max(0, (int) $limit) : 0;
        if ($limit > 0) {
            $sql .= ' WHERE rowid IN (SELECT rowid FROM ' . $table
                . $whereClause . $orderClause . ' LIMIT ' . $limit . ')';
        } else {
            $sql .= $whereClause;
        }

        try {
            return $this->executeNonSelect($sql, $whereParams);
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        } finally {
            $this->resetQueryState();
        }
    }

    public function rawQuery($query, $bindParams = array())
    {
        if (!is_array($bindParams)) {
            $bindParams = array($bindParams);
        }

        $query = trim($query);
        $query = $this->translateQuery($query);
        $statementType = strtoupper(strtok($query, " \t\n\r\0\x0B"));

        try {
            if (in_array($statementType, array('SELECT', 'PRAGMA', 'WITH'))) {
                return $this->executeSelect($query, $bindParams);
            }

            $result = $this->executeNonSelect($query, $bindParams);
            if ($statementType === 'DELETE') {
                return $result;
            }
            return true;
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        } finally {
            $this->resetQueryState();
        }
    }

    protected function executeSelect($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $start = microtime(true);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->recordTrace($sql, $params, $start);
        return $rows;
    }

    protected function executeNonSelect($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $start = microtime(true);
        $stmt->execute($params);
        $this->recordTrace($sql, $params, $start);
        return $stmt->rowCount();
    }

    protected function buildJoinClause()
    {
        return $this->joins ? ' ' . implode(' ', $this->joins) : '';
    }

    protected function buildWhereClause(&$params)
    {
        $params = array();
        if (!$this->wheres) {
            return '';
        }

        $clauses = array();
        foreach ($this->wheres as $where) {
            $clauses[] = '(' . $where['condition'] . ')';
            if (!empty($where['params'])) {
                $params = array_merge($params, $where['params']);
            }
        }

        return ' WHERE ' . implode(' AND ', $clauses);
    }

    protected function buildGroupByClause()
    {
        return $this->groupBys ? ' GROUP BY ' . implode(', ', $this->groupBys) : '';
    }

    protected function buildOrderByClause()
    {
        return $this->orderBys ? ' ORDER BY ' . implode(', ', $this->orderBys) : '';
    }

    protected function buildLimitClause($limit)
    {
        if ($limit === null || $limit === '') {
            return '';
        }

        if (is_numeric($limit)) {
            $limit = (int) $limit;
            if ($limit > 0) {
                return ' LIMIT ' . $limit;
            }
        }

        return '';
    }

    protected function addWhere($condition, $params = array())
    {
        $this->wheres[] = array(
            'condition' => $this->translateSqlFunctions($condition),
            'params' => $params
        );
    }

    protected function addFieldCondition($field, $operator, $value)
    {
        $operator = strtoupper(trim((string) $operator));
        if ($operator === '') {
            $operator = '=';
        }

        if (($operator === 'IN' || $operator === 'NOT IN') && is_array($value)) {
            if (!$value) {
                $this->addWhere($operator === 'IN' ? '1 = 0' : '1 = 1', array());
                return;
            }

            $placeholders = implode(',', array_fill(0, count($value), '?'));
            $this->addWhere($field . ' ' . $operator . ' (' . $placeholders . ')', array_values($value));
            return;
        }

        if ($value === null) {
            if (in_array($operator, array('!=', '<>', 'IS NOT', 'NOT'))) {
                $this->addWhere($field . ' IS NOT NULL', array());
            } else {
                $this->addWhere($field . ' IS NULL', array());
            }
            return;
        }

        $this->addWhere($field . ' ' . $operator . ' ?', array($value));
    }

    protected function translateQuery($query)
    {
        $query = preg_replace('/\bRAND\(\)/i', 'RANDOM()', $query);
        $query = $this->rewriteUpdateDeleteWithLimit($query);
        return $query;
    }

    protected function rewriteUpdateDeleteWithLimit($query)
    {
        $query = trim($query);
        $queryNoSemicolon = rtrim($query, ';');

        if (preg_match('/^UPDATE\s+([^\s]+)\s+SET\s+(.+?)\s+WHERE\s+(.+)\s+LIMIT\s+(\d+)$/is', $queryNoSemicolon, $m)) {
            return 'UPDATE ' . $m[1] . ' SET ' . $m[2]
                . ' WHERE rowid IN (SELECT rowid FROM ' . $m[1]
                . ' WHERE ' . $m[3] . ' LIMIT ' . (int) $m[4] . ')';
        }

        if (preg_match('/^DELETE\s+FROM\s+([^\s]+)\s+WHERE\s+(.+)\s+LIMIT\s+(\d+)$/is', $queryNoSemicolon, $m)) {
            return 'DELETE FROM ' . $m[1]
                . ' WHERE rowid IN (SELECT rowid FROM ' . $m[1]
                . ' WHERE ' . $m[2] . ' LIMIT ' . (int) $m[3] . ')';
        }

        return $queryNoSemicolon;
    }

    protected function translateSqlFunctions($sqlPart)
    {
        return preg_replace('/\bRAND\(\)/i', 'RANDOM()', $sqlPart);
    }

    protected function hasPlaceholders($value)
    {
        return is_string($value) && strpos($value, '?') !== false;
    }

    protected function isAssociativeArray(array $array)
    {
        if (array() === $array) {
            return false;
        }
        return array_keys($array) !== range(0, count($array) - 1);
    }

    protected function recordTrace($query, $params, $startTime)
    {
        if (!$this->traceEnabled) {
            return;
        }

        $this->trace[] = array(
            'query' => $query,
            'params' => $params,
            'time' => round((microtime(true) - $startTime) * 1000, 2)
        );
    }

    protected function resetQueryState()
    {
        $this->wheres = array();
        $this->joins = array();
        $this->orderBys = array();
        $this->groupBys = array();
    }
}
