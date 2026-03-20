<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/Container.php';
require_once __DIR__ . '/../includes/class/SqliteDb.php';
require_once __DIR__ . '/../includes/class/alpha.class.php';
require_once __DIR__ . '/../includes/class/userclass.php';
require_once __DIR__ . '/../includes/class/taskclass.php';

/**
 * Tests that real service classes (UserClass, Tasks) can be constructed and
 * operated with a Container, proving the DI wiring works end-to-end.
 */
final class ServiceWiringTest extends TestCase
{
    private static string $dbPath;
    private Container $container;

    public static function setUpBeforeClass(): void
    {
        self::$dbPath = sys_get_temp_dir() . '/sr_di_wiring_' . getmypid() . '.sqlite';
    }

    protected function setUp(): void
    {
        if (file_exists(self::$dbPath)) {
            unlink(self::$dbPath);
        }

        $db = new SqliteDb(self::$dbPath);
        $db->setTrace(true);

        // Create minimal schema for the tests
        $db->rawQuery('CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL DEFAULT \'\',
            money REAL NOT NULL DEFAULT 0,
            energy INTEGER NOT NULL DEFAULT 100,
            maxEnergy INTEGER NOT NULL DEFAULT 100,
            exp INTEGER NOT NULL DEFAULT 0,
            expNext INTEGER NOT NULL DEFAULT 100,
            level INTEGER NOT NULL DEFAULT 1,
            tasks INTEGER NOT NULL DEFAULT 0,
            server INTEGER DEFAULT NULL,
            skillPoints INTEGER NOT NULL DEFAULT 0,
            alphaCoins INTEGER NOT NULL DEFAULT 0,
            rewardsToReceive INTEGER NOT NULL DEFAULT 0,
            dataPoints REAL NOT NULL DEFAULT 0,
            dataPointsPerHour REAL NOT NULL DEFAULT 0,
            lastActive INTEGER DEFAULT NULL,
            organization INTEGER DEFAULT NULL,
            `rank` INTEGER DEFAULT NULL,
            zone INTEGER DEFAULT NULL,
            main_node INTEGER DEFAULT NULL,
            zrank INTEGER DEFAULT NULL,
            points INTEGER DEFAULT 0,
            org_group INTEGER DEFAULT NULL,
            blogs INTEGER DEFAULT 0,
            in_party INTEGER DEFAULT NULL,
            aiVoice INTEGER DEFAULT 0,
            gavatar TEXT DEFAULT NULL,
            tutorial INTEGER DEFAULT 0,
            cardinal INTEGER DEFAULT 0
        )');
        $db->rawQuery('CREATE TABLE tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uid INTEGER NOT NULL,
            type INTEGER NOT NULL,
            start INTEGER NOT NULL,
            totalSeconds INTEGER NOT NULL,
            data TEXT DEFAULT NULL,
            dataid INTEGER DEFAULT NULL,
            name TEXT DEFAULT \'\',
            paused INTEGER DEFAULT NULL,
            party_id INTEGER DEFAULT NULL,
            instance_id INTEGER DEFAULT NULL
        )');
        $db->rawQuery('CREATE TABLE task_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uid INTEGER, type INTEGER, start INTEGER, totalSeconds INTEGER,
            data TEXT, dataid INTEGER, name TEXT, party_id INTEGER, instance_id INTEGER,
            log_created INTEGER
        )');
        $db->rawQuery('CREATE TABLE skills (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uid INTEGER NOT NULL,
            skill INTEGER NOT NULL,
            exp INTEGER NOT NULL DEFAULT 0,
            expNext INTEGER NOT NULL DEFAULT 10,
            level INTEGER NOT NULL DEFAULT 1
        )');
        $db->rawQuery('CREATE TABLE friendships (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user1id INTEGER NOT NULL,
            user2id INTEGER NOT NULL,
            date INTEGER DEFAULT NULL
        )');
        $db->rawQuery('CREATE TABLE user_premium (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL
        )');
        $db->rawQuery('CREATE TABLE user_rewards (
            reward_id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            created INTEGER,
            title TEXT,
            money REAL DEFAULT 0,
            exp INTEGER DEFAULT 0,
            skillPoints INTEGER DEFAULT 0,
            alphaCoins INTEGER DEFAULT 0,
            dataPoints REAL DEFAULT 0,
            energy INTEGER DEFAULT 0,
            jobExp INTEGER DEFAULT 0,
            skills TEXT,
            achievements TEXT,
            applications TEXT,
            components TEXT,
            received INTEGER DEFAULT NULL,
            referral_id INTEGER DEFAULT NULL
        )');
        $db->rawQuery('CREATE TABLE party_quest_instances (
            instance_id INTEGER PRIMARY KEY AUTOINCREMENT,
            start INTEGER,
            totalSeconds INTEGER
        )');

        // Seed a test user
        $db->insert('users', [
            'username' => 'testhacker',
            'money' => 1000,
            'energy' => 100,
            'maxEnergy' => 100,
            'level' => 5,
            'exp' => 0,
            'expNext' => 200,
        ]);

        $this->container = new Container();
        $this->container->set('db', $db);
        $this->container->set('config', [
            'url' => 'http://test/',
            'max_tasks' => 3,
            'tutorialSteps' => 18,
            'defaultGroup' => 1,
        ]);
        $this->container->set('user', [
            'id' => 1,
            'username' => 'testhacker',
            'tasks' => 0,
            'server' => null,
            'level' => 5,
        ]);

        // Register services as lazy factories — same pattern as index.php
        $c = $this->container;
        $c->factory('uclass', function (Container $c) {
            return new UserClass($c);
        });
        $c->factory('taskclass', function (Container $c) {
            return new Tasks($c);
        });
    }

    protected function tearDown(): void
    {
        if (file_exists(self::$dbPath)) {
            unlink(self::$dbPath);
        }
    }

    // ------------------------------------------------------------------
    // UserClass via Container
    // ------------------------------------------------------------------

    public function testUserClassIsLazilyCreated(): void
    {
        // Before first access, the factory should not have run
        $this->assertTrue($this->container->has('uclass'));
        $uclass = $this->container->uclass();
        $this->assertInstanceOf(UserClass::class, $uclass);
    }

    public function testUserClassIsSingleton(): void
    {
        $first  = $this->container->uclass();
        $second = $this->container->uclass();
        $this->assertSame($first, $second);
    }

    public function testUserClassCanAccessDbThroughContainer(): void
    {
        $uclass = $this->container->uclass();
        // getUserSkills triggers a DB query — if wiring is broken this throws
        $skills = $uclass->getUserSkills(1, [1]);
        $this->assertIsArray($skills);
    }

    public function testUpdatePlayerWritesThroughContainer(): void
    {
        $uclass = $this->container->uclass();
        $uclass->updatePlayer(['money' => 2000]);

        // Verify DB was updated
        $db = $this->container->db();
        $row = $db->where('id', 1)->getOne('users', 'money');
        $this->assertEquals(2000, $row['money']);

        // Verify in-memory user was updated too
        $user = $this->container->get('user');
        $this->assertEquals(2000, $user['money']);
    }

    public function testGetPremiumDataCreatesMissingRecord(): void
    {
        $uclass = $this->container->uclass();
        $premium = $uclass->getPremiumData(1);
        $this->assertArrayHasKey('id', $premium);
    }

    public function testAreUsersFriendsReturnsFalseForStrangers(): void
    {
        $uclass = $this->container->uclass();
        $this->assertFalse($uclass->areUsersFriends(1, 999));
    }

    public function testAreUsersFriendsReturnsTrueForFriends(): void
    {
        $db = $this->container->db();
        $db->insert('friendships', ['user1id' => 1, 'user2id' => 2, 'date' => time()]);

        $uclass = $this->container->uclass();
        $this->assertNotFalse($uclass->areUsersFriends(1, 2));
    }

    public function testAddRewardCreatesRewardRecord(): void
    {
        $uclass = $this->container->uclass();
        $rewardId = $uclass->addReward(1, ['money' => 500], 'Test Reward');

        $db = $this->container->db();
        $reward = $db->where('reward_id', $rewardId)->getOne('user_rewards');
        $this->assertSame('Test Reward', $reward['title']);
        $this->assertEquals(500, $reward['money']);
    }

    // ------------------------------------------------------------------
    // Tasks via Container
    // ------------------------------------------------------------------

    public function testTaskClassIsLazilyCreated(): void
    {
        $taskclass = $this->container->taskclass();
        $this->assertInstanceOf(Tasks::class, $taskclass);
    }

    public function testTaskClassIsSingleton(): void
    {
        $first  = $this->container->taskclass();
        $second = $this->container->taskclass();
        $this->assertSame($first, $second);
    }

    public function testAddAndFetchTask(): void
    {
        $taskclass = $this->container->taskclass();
        $user = $this->container->get('user');

        $taskData = $taskclass->add_task_session(
            $user['id'], 15, 300, ['quest' => 1], 1, 'Test Quest'
        );

        $this->assertArrayHasKey('uid', $taskData);
        $this->assertSame($user['id'], $taskData['uid']);

        // Fetch it back
        $fetched = $taskclass->check_fetch_task($user, 15);
        $this->assertNotFalse($fetched);
        $this->assertSame(15, (int)$fetched['type']);
    }

    public function testProcessTaskGeneral(): void
    {
        $taskclass = $this->container->taskclass();
        $task = [
            'start' => time() - 100,
            'totalSeconds' => 300,
        ];
        $taskclass->process_task_general($task);

        $this->assertArrayHasKey('finish', $task);
        $this->assertArrayHasKey('remainingSeconds', $task);
        $this->assertGreaterThan(0, $task['remainingSeconds']);
    }

    public function testDeleteTaskSession(): void
    {
        $taskclass = $this->container->taskclass();
        $user = $this->container->get('user');

        $taskclass->add_task_session($user['id'], 15, 300, [], null, 'temp');
        $taskclass->delete_task_session($user['id'], 15);

        $fetched = $taskclass->check_fetch_task($user, 15);
        $this->assertFalse($fetched);
    }

    // ------------------------------------------------------------------
    // Cross-service interaction through shared Container
    // ------------------------------------------------------------------

    public function testUserClassAndTaskClassShareSameDb(): void
    {
        $uclass    = $this->container->uclass();
        $taskclass = $this->container->taskclass();

        // Both should be operating on the same database
        // Add a task, then verify we can query it through uclass's db
        $user = $this->container->get('user');
        $taskclass->add_task_session($user['id'], 99, 60, [], null, 'cross-test');

        $db = $this->container->db();
        $row = $db->where('uid', $user['id'])->where('type', 99)->getOne('tasks');
        $this->assertSame('cross-test', $row['name']);
    }

    public function testServicesShareContainerErrors(): void
    {
        $uclass    = $this->container->uclass();
        $taskclass = $this->container->taskclass();

        // Both instances write to the same errors array
        $uclass->errors[] = 'from uclass';
        $taskclass->errors[] = 'from taskclass';

        $this->assertCount(2, $this->container->errors);
        $this->assertContains('from uclass', $this->container->errors);
        $this->assertContains('from taskclass', $this->container->errors);
    }
}
