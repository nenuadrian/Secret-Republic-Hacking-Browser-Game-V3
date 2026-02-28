<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/SqliteDb.php';
require_once __DIR__ . '/../includes/class/SqliteSchemaConverter.php';

/**
 * End-to-end test: convert the real DB.sql schema, import it,
 * then run the same operations the setup page and registration flow perform.
 */
final class SqliteSetupIntegrationTest extends TestCase
{
    private static $dbPath;
    private $db;

    public static function setUpBeforeClass(): void
    {
        self::$dbPath = sys_get_temp_dir() . '/sr_integration_test_' . getmypid() . '.sqlite';
    }

    protected function setUp(): void
    {
        if (file_exists(self::$dbPath)) {
            unlink(self::$dbPath);
        }

        $this->db = new SqliteDb(self::$dbPath);
        $sql = file_get_contents(__DIR__ . '/../includes/install/DB.sql');
        $statements = SqliteSchemaConverter::convertMySqlDump($sql);
        foreach ($statements as $stmt) {
            $this->db->rawQuery($stmt);
        }
    }

    protected function tearDown(): void
    {
        $this->db = null;
        if (file_exists(self::$dbPath)) {
            unlink(self::$dbPath);
        }
    }

    public function testAllTablesCreated(): void
    {
        $tables = $this->db->rawQuery(
            "SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name"
        );
        $this->assertCount(100, $tables);
    }

    public function testSeedDataImported(): void
    {
        $shop = $this->db->get('alpha_coins_shop');
        $this->assertGreaterThan(0, count($shop), 'alpha_coins_shop should have seed data');

        $apps = $this->db->get('applications');
        $this->assertGreaterThan(0, count($apps), 'applications should have seed data');
    }

    public function testSeedDataEscapesPreserved(): void
    {
        // Item 4 has \r\n in MySQL dump that should be real newlines now
        $item = $this->db->where('item_id', 4)->getOne('alpha_coins_shop', 'description');
        $this->assertStringNotContainsString('\\n', $item['description'], 'Should not have literal backslash-n');
        $this->assertStringNotContainsString('\\r', $item['description'], 'Should not have literal backslash-r');
    }

    public function testUserRegistrationFlow(): void
    {
        // Step 1: Insert user (like registrationSystem::addUser)
        $uid = $this->db->insert('users', [
            'username' => 'testadmin',
            'zone' => 1,
            'main_node' => '1:1:5',
            'expNext' => 135,
            'maxEnergy' => 100,
            'energy' => 100,
            'gavatar' => md5('admin@test.com'),
            'createdAt' => time()
        ]);
        $this->assertIsInt($uid);
        $this->assertGreaterThan(0, $uid);

        // Step 2: Insert credentials
        $credResult = $this->db->insert('user_credentials', [
            'uid' => $uid,
            'password' => password_hash('testpass', PASSWORD_DEFAULT),
            'group_id' => 2,
            'email' => 'admin@test.com',
            'pin' => md5('1234'),
        ]);
        $this->assertNotFalse($credResult);

        // Step 3: Promote to admin (like setup.php)
        $result = $this->db->where('uid', $uid)->update('user_credentials', [
            'group_id' => 1,
            'email_confirmed' => 1
        ]);
        $this->assertTrue($result);

        // Step 4: Verify via join (like the game does)
        $row = $this->db->join('user_credentials uc', 'users.id = uc.uid')
            ->where('users.id', $uid)
            ->getOne('users', 'users.username, uc.group_id, uc.email_confirmed');
        $this->assertSame('testadmin', $row['username']);
        $this->assertEquals(1, $row['group_id']);
        $this->assertEquals(1, $row['email_confirmed']);
    }

    public function testUserPremiumFlow(): void
    {
        $uid = $this->db->insert('users', [
            'username' => 'premuser',
            'gavatar' => md5('prem@test.com'),
        ]);

        // Insert premium row
        $premId = $this->db->insert('user_premium', ['user_id' => $uid]);
        $this->assertNotFalse($premId);

        // Update premium (like sendWelcomeStuffAndBonuses)
        $until = time() + 4 * 24 * 60 * 60;
        $result = $this->db->where('user_id', $uid)->update('user_premium', [
            'ai' => $until,
            'missionNotepad' => $until,
        ], 1);
        $this->assertTrue($result);
    }

    public function testCronStyleUpdates(): void
    {
        // Subquery-based update (from cron/daily.php)
        $result = $this->db->rawQuery(
            'UPDATE organizations SET nrm = (SELECT count(*) FROM users u WHERE u.organization = organizations.id)'
        );
        $this->assertNotFalse($result);
    }

    public function testGridNodeQueries(): void
    {
        // Cluster query (from registrationSystem::findAvailableGridNode)
        $clusters = $this->db->rawQuery(
            'SELECT cluster FROM zone_grid_clusters zgc
             WHERE zgc.zone_id = ? AND 10 > (
                SELECT count(*) FROM zone_grid_cluster_nodes zgcn
                WHERE zgcn.cluster = zgc.cluster AND zgcn.zone_id = ? AND zgcn.user_id IS NOT NULL LIMIT 1
             )
             ORDER BY zgc.cluster ASC LIMIT 1',
            [1, 1]
        );
        $this->assertIsArray($clusters);
    }

    public function testConversationQueries(): void
    {
        // Count query (from conversations.php)
        $result = $this->db->rawQuery(
            'SELECT count(*) nrm FROM conversations m WHERE parent_message_id IS NULL AND (m.sender_user_id = ? OR m.receiver_user_id = ?)',
            [1, 1]
        );
        $this->assertIsArray($result);
        $this->assertEquals(0, $result[0]['nrm']);
    }

    public function testRandOrderWorks(): void
    {
        $this->db->insert('users', ['username' => 'a']);
        $this->db->insert('users', ['username' => 'b']);

        $rows = $this->db->rawQuery('SELECT * FROM users ORDER BY RAND() LIMIT 1');
        $this->assertCount(1, $rows);
    }

    public function testDeleteRawQueryFromCron(): void
    {
        $this->db->insert('users', ['username' => null, 'gavatar' => '']);
        $result = $this->db->rawQuery('DELETE FROM users WHERE username IS NULL');
        $this->assertIsInt($result);
    }
}
