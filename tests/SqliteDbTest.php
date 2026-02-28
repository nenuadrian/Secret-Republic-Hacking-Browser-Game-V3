<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/SqliteDb.php';

final class SqliteDbTest extends TestCase
{
    private static $dbPath;
    private $db;

    public static function setUpBeforeClass(): void
    {
        self::$dbPath = sys_get_temp_dir() . '/sr_sqlitedb_test_' . getmypid() . '.sqlite';
    }

    protected function setUp(): void
    {
        if (file_exists(self::$dbPath)) {
            unlink(self::$dbPath);
        }
        $this->db = new SqliteDb(self::$dbPath);
        $this->db->rawQuery('CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL DEFAULT \'\',
            level INTEGER NOT NULL DEFAULT 1,
            score REAL NOT NULL DEFAULT 0,
            zone INTEGER DEFAULT NULL,
            created INTEGER DEFAULT NULL
        )');
        $this->db->rawQuery('CREATE TABLE credentials (
            uid INTEGER NOT NULL,
            email TEXT DEFAULT NULL,
            group_id INTEGER NOT NULL DEFAULT 0
        )');
    }

    protected function tearDown(): void
    {
        $this->db = null;
        if (file_exists(self::$dbPath)) {
            unlink(self::$dbPath);
        }
    }

    // ---- INSERT ----

    public function testInsertReturnsId(): void
    {
        $id = $this->db->insert('users', ['username' => 'alice', 'level' => 5]);
        $this->assertSame(1, $id);

        $id2 = $this->db->insert('users', ['username' => 'bob']);
        $this->assertSame(2, $id2);
    }

    public function testInsertInvalidPayloadReturnsFalse(): void
    {
        $result = $this->db->insert('users', []);
        $this->assertFalse($result);
    }

    // ---- GET / getOne ----

    public function testGetReturnsAllRows(): void
    {
        $this->db->insert('users', ['username' => 'a']);
        $this->db->insert('users', ['username' => 'b']);
        $this->db->insert('users', ['username' => 'c']);

        $rows = $this->db->get('users');
        $this->assertCount(3, $rows);
    }

    public function testGetWithLimit(): void
    {
        $this->db->insert('users', ['username' => 'a']);
        $this->db->insert('users', ['username' => 'b']);
        $this->db->insert('users', ['username' => 'c']);

        $rows = $this->db->get('users', 2);
        $this->assertCount(2, $rows);
    }

    public function testGetWithColumns(): void
    {
        $this->db->insert('users', ['username' => 'alice', 'level' => 10]);
        $rows = $this->db->get('users', null, 'username, level');
        $this->assertArrayHasKey('username', $rows[0]);
        $this->assertArrayHasKey('level', $rows[0]);
        $this->assertArrayNotHasKey('id', $rows[0]);
    }

    public function testGetOneReturnsSingleRow(): void
    {
        $this->db->insert('users', ['username' => 'alice']);
        $row = $this->db->where('username', 'alice')->getOne('users');
        $this->assertSame('alice', $row['username']);
    }

    public function testGetOneReturnsEmptyArrayWhenNoMatch(): void
    {
        $row = $this->db->where('username', 'nonexistent')->getOne('users');
        $this->assertSame([], $row);
    }

    // ---- WHERE ----

    public function testWhereEquals(): void
    {
        $this->db->insert('users', ['username' => 'alice', 'level' => 5]);
        $this->db->insert('users', ['username' => 'bob', 'level' => 10]);

        $rows = $this->db->where('level', 5)->get('users');
        $this->assertCount(1, $rows);
        $this->assertSame('alice', $rows[0]['username']);
    }

    public function testWhereIn(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 1]);
        $this->db->insert('users', ['username' => 'b', 'level' => 2]);
        $this->db->insert('users', ['username' => 'c', 'level' => 3]);

        $rows = $this->db->where('level', [1, 3], 'IN')->get('users');
        $this->assertCount(2, $rows);
    }

    public function testWhereInWithEmptyArray(): void
    {
        $this->db->insert('users', ['username' => 'a']);
        $rows = $this->db->where('level', [], 'IN')->get('users');
        $this->assertCount(0, $rows);
    }

    public function testWhereIsNull(): void
    {
        $this->db->insert('users', ['username' => 'a', 'zone' => 1]);
        $this->db->insert('users', ['username' => 'b', 'zone' => null]);

        $rows = $this->db->where('zone', null)->get('users');
        $this->assertCount(1, $rows);
        $this->assertSame('b', $rows[0]['username']);
    }

    public function testWhereIsNotNull(): void
    {
        $this->db->insert('users', ['username' => 'a', 'zone' => 1]);
        $this->db->insert('users', ['username' => 'b', 'zone' => null]);

        $rows = $this->db->where('zone', null, '!=')->get('users');
        $this->assertCount(1, $rows);
        $this->assertSame('a', $rows[0]['username']);
    }

    public function testWhereWithOperatorMap(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 5]);
        $this->db->insert('users', ['username' => 'b', 'level' => 10]);
        $this->db->insert('users', ['username' => 'c', 'level' => 15]);

        $rows = $this->db->where('level', ['>=' => 10])->get('users');
        $this->assertCount(2, $rows);
    }

    public function testWhereWithPlaceholder(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 5]);
        $this->db->insert('users', ['username' => 'b', 'level' => 10]);

        $rows = $this->db->where('level > ?', [7])->get('users');
        $this->assertCount(1, $rows);
        $this->assertSame('b', $rows[0]['username']);
    }

    public function testMultipleWhereConditions(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 5, 'zone' => 1]);
        $this->db->insert('users', ['username' => 'b', 'level' => 5, 'zone' => 2]);
        $this->db->insert('users', ['username' => 'c', 'level' => 10, 'zone' => 1]);

        $rows = $this->db->where('level', 5)->where('zone', 1)->get('users');
        $this->assertCount(1, $rows);
        $this->assertSame('a', $rows[0]['username']);
    }

    // ---- UPDATE ----

    public function testUpdateWithWhere(): void
    {
        $id = $this->db->insert('users', ['username' => 'alice', 'level' => 1]);
        $this->db->where('id', $id)->update('users', ['level' => 99]);

        $row = $this->db->where('id', $id)->getOne('users', 'level');
        $this->assertEquals(99, $row['level']);
    }

    public function testUpdateWithLimit(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 1]);
        $this->db->insert('users', ['username' => 'b', 'level' => 1]);

        $this->db->where('level', 1)->update('users', ['level' => 2], 1);

        $rows = $this->db->where('level', 2)->get('users');
        $this->assertCount(1, $rows, 'Only 1 row should be updated when LIMIT 1');
    }

    // ---- DELETE ----

    public function testDeleteWithWhere(): void
    {
        $this->db->insert('users', ['username' => 'a']);
        $this->db->insert('users', ['username' => 'b']);

        $this->db->where('username', 'a')->delete('users');

        $rows = $this->db->get('users');
        $this->assertCount(1, $rows);
        $this->assertSame('b', $rows[0]['username']);
    }

    public function testDeleteWithLimit(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 1]);
        $this->db->insert('users', ['username' => 'b', 'level' => 1]);

        $this->db->where('level', 1)->delete('users', 1);

        $rows = $this->db->get('users');
        $this->assertCount(1, $rows, 'Only 1 row should be deleted when LIMIT 1');
    }

    // ---- ORDER BY ----

    public function testOrderBy(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 10]);
        $this->db->insert('users', ['username' => 'b', 'level' => 5]);
        $this->db->insert('users', ['username' => 'c', 'level' => 20]);

        $rows = $this->db->orderBy('level', 'ASC')->get('users', null, 'username, level');
        $this->assertSame('b', $rows[0]['username']);
        $this->assertSame('c', $rows[2]['username']);
    }

    // ---- GROUP BY ----

    public function testGroupBy(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 1]);
        $this->db->insert('users', ['username' => 'b', 'level' => 1]);
        $this->db->insert('users', ['username' => 'c', 'level' => 2]);

        $rows = $this->db->groupBy('level')->get('users', null, 'level, count(*) as cnt');
        $this->assertCount(2, $rows);
    }

    // ---- JOIN ----

    public function testJoin(): void
    {
        $uid = $this->db->insert('users', ['username' => 'alice']);
        $this->db->insert('credentials', ['uid' => $uid, 'email' => 'a@b.c', 'group_id' => 1]);

        $row = $this->db->join('credentials c', 'users.id = c.uid')
            ->where('users.id', $uid)
            ->getOne('users', 'users.username, c.email, c.group_id');

        $this->assertSame('alice', $row['username']);
        $this->assertSame('a@b.c', $row['email']);
        $this->assertEquals(1, $row['group_id']);
    }

    public function testLeftJoin(): void
    {
        $uid = $this->db->insert('users', ['username' => 'alone']);

        $row = $this->db->join('credentials c', 'users.id = c.uid', 'LEFT')
            ->where('users.id', $uid)
            ->getOne('users', 'users.username, c.email');

        $this->assertSame('alone', $row['username']);
        $this->assertNull($row['email']);
    }

    // ---- PAGINATE ----

    public function testPaginate(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->db->insert('users', ['username' => "user$i"]);
        }

        $this->db->pageLimit = 2;
        $page1 = $this->db->orderBy('id', 'ASC')->paginate('users', 1, 'username');
        $page2 = $this->db->orderBy('id', 'ASC')->paginate('users', 2, 'username');
        $page3 = $this->db->orderBy('id', 'ASC')->paginate('users', 3, 'username');

        $this->assertCount(2, $page1);
        $this->assertCount(2, $page2);
        $this->assertCount(1, $page3);
        $this->assertSame('user1', $page1[0]['username']);
        $this->assertSame('user3', $page2[0]['username']);
        $this->assertSame('user5', $page3[0]['username']);
    }

    // ---- RAW QUERY ----

    public function testRawQuerySelect(): void
    {
        $this->db->insert('users', ['username' => 'alice', 'level' => 5]);
        $rows = $this->db->rawQuery('SELECT * FROM users WHERE level = ?', [5]);
        $this->assertCount(1, $rows);
        $this->assertSame('alice', $rows[0]['username']);
    }

    public function testRawQueryUpdate(): void
    {
        $this->db->insert('users', ['username' => 'alice', 'level' => 1]);
        $result = $this->db->rawQuery('UPDATE users SET level = ? WHERE username = ?', [99, 'alice']);
        $this->assertTrue($result);

        $row = $this->db->where('username', 'alice')->getOne('users', 'level');
        $this->assertEquals(99, $row['level']);
    }

    public function testRawQueryTranslatesRandToRandom(): void
    {
        $this->db->insert('users', ['username' => 'a']);
        $this->db->insert('users', ['username' => 'b']);

        $rows = $this->db->rawQuery('SELECT * FROM users ORDER BY RAND() LIMIT 1');
        $this->assertCount(1, $rows);
    }

    public function testRawQueryRewritesUpdateWithLimit(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 1]);
        $this->db->insert('users', ['username' => 'b', 'level' => 1]);

        $result = $this->db->rawQuery("UPDATE users SET level = 2 WHERE level = 1 LIMIT 1");
        $this->assertTrue($result);

        $rows = $this->db->where('level', 2)->get('users');
        $this->assertCount(1, $rows);
    }

    public function testRawQueryRewritesDeleteWithLimit(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 1]);
        $this->db->insert('users', ['username' => 'b', 'level' => 1]);

        $this->db->rawQuery("DELETE FROM users WHERE level = 1 LIMIT 1");

        $rows = $this->db->get('users');
        $this->assertCount(1, $rows);
    }

    public function testRawQuerySubqueries(): void
    {
        $this->db->insert('users', ['username' => 'a']);
        $rows = $this->db->rawQuery(
            'SELECT (SELECT count(*) FROM users) as total, (SELECT count(*) FROM credentials) as creds'
        );
        $this->assertEquals(1, $rows[0]['total']);
        $this->assertEquals(0, $rows[0]['creds']);
    }

    // ---- ERROR HANDLING ----

    public function testGetLastError(): void
    {
        $result = $this->db->rawQuery('SELECT * FROM nonexistent_table');
        $this->assertFalse($result);
        $this->assertNotEmpty($this->db->getLastError());
    }

    // ---- TRACE ----

    public function testTrace(): void
    {
        $this->db->setTrace(true);
        $this->db->insert('users', ['username' => 'traced']);

        $this->assertCount(1, $this->db->trace);
        $this->assertArrayHasKey('query', $this->db->trace[0]);
        $this->assertArrayHasKey('params', $this->db->trace[0]);
        $this->assertArrayHasKey('time', $this->db->trace[0]);
    }

    // ---- QUERY STATE RESET ----

    public function testQueryStateResetsAfterGet(): void
    {
        $this->db->insert('users', ['username' => 'a', 'level' => 1]);
        $this->db->insert('users', ['username' => 'b', 'level' => 2]);

        // First query with where
        $this->db->where('level', 1)->get('users');
        // Second query without where should return all rows (state was reset)
        $rows = $this->db->get('users');
        $this->assertCount(2, $rows);
    }

    public function testQueryStateResetsAfterError(): void
    {
        // This should fail and still reset state
        $this->db->where('level', 1)->rawQuery('SELECT * FROM nonexistent');
        // Next query should work without leftover where
        $this->db->insert('users', ['username' => 'a']);
        $rows = $this->db->get('users');
        $this->assertCount(1, $rows);
    }
}
