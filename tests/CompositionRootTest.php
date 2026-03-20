<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/Container.php';
require_once __DIR__ . '/../includes/class/SqliteDb.php';
require_once __DIR__ . '/../includes/class/alpha.class.php';
require_once __DIR__ . '/../includes/class/userclass.php';
require_once __DIR__ . '/../includes/class/taskclass.php';

/**
 * Simulates the composition root (index.php) wiring pattern and verifies
 * that the full service graph works correctly with lazy factories.
 */
final class CompositionRootTest extends TestCase
{
    private static string $dbPath;

    public static function setUpBeforeClass(): void
    {
        self::$dbPath = sys_get_temp_dir() . '/sr_composition_' . getmypid() . '.sqlite';
    }

    protected function tearDown(): void
    {
        if (file_exists(self::$dbPath)) {
            unlink(self::$dbPath);
        }
    }

    /**
     * Build a container the same way index.php does.
     */
    private function buildContainer(): Container
    {
        if (file_exists(self::$dbPath)) {
            unlink(self::$dbPath);
        }

        $container = new Container();

        // DB setup (same as Cardinal would do)
        $db = new SqliteDb(self::$dbPath);
        $db->setTrace(true);
        $db->rawQuery('CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT DEFAULT \'\', money REAL DEFAULT 0,
            energy INTEGER DEFAULT 100, maxEnergy INTEGER DEFAULT 100,
            exp INTEGER DEFAULT 0, expNext INTEGER DEFAULT 100,
            level INTEGER DEFAULT 1, tasks INTEGER DEFAULT 0,
            server INTEGER DEFAULT NULL, skillPoints INTEGER DEFAULT 0,
            alphaCoins INTEGER DEFAULT 0, rewardsToReceive INTEGER DEFAULT 0,
            dataPoints REAL DEFAULT 0, dataPointsPerHour REAL DEFAULT 0,
            lastActive INTEGER DEFAULT NULL, organization INTEGER DEFAULT NULL,
            `rank` INTEGER DEFAULT NULL, zone INTEGER DEFAULT NULL,
            main_node INTEGER DEFAULT NULL, zrank INTEGER DEFAULT NULL,
            points INTEGER DEFAULT 0, org_group INTEGER DEFAULT NULL,
            blogs INTEGER DEFAULT 0, in_party INTEGER DEFAULT NULL,
            aiVoice INTEGER DEFAULT 0, gavatar TEXT DEFAULT NULL,
            tutorial INTEGER DEFAULT 0, cardinal INTEGER DEFAULT 0
        )');
        $db->rawQuery('CREATE TABLE tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uid INTEGER, type INTEGER, start INTEGER, totalSeconds INTEGER,
            data TEXT, dataid INTEGER, name TEXT DEFAULT \'\',
            paused INTEGER DEFAULT NULL, party_id INTEGER DEFAULT NULL,
            instance_id INTEGER DEFAULT NULL
        )');
        $db->rawQuery('CREATE TABLE task_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uid INTEGER, type INTEGER, start INTEGER, totalSeconds INTEGER,
            data TEXT, dataid INTEGER, name TEXT, party_id INTEGER,
            instance_id INTEGER, log_created INTEGER
        )');
        $db->rawQuery('CREATE TABLE skills (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uid INTEGER, skill INTEGER, exp INTEGER DEFAULT 0,
            expNext INTEGER DEFAULT 10, level INTEGER DEFAULT 1
        )');
        $db->rawQuery('CREATE TABLE friendships (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user1id INTEGER, user2id INTEGER, date INTEGER
        )');
        $db->rawQuery('CREATE TABLE user_premium (
            id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER
        )');
        $db->rawQuery('CREATE TABLE user_rewards (
            reward_id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER, created INTEGER, title TEXT,
            money REAL DEFAULT 0, exp INTEGER DEFAULT 0,
            skillPoints INTEGER DEFAULT 0, alphaCoins INTEGER DEFAULT 0,
            dataPoints REAL DEFAULT 0, energy INTEGER DEFAULT 0,
            jobExp INTEGER DEFAULT 0, skills TEXT, achievements TEXT,
            applications TEXT, components TEXT, received INTEGER DEFAULT NULL,
            referral_id INTEGER DEFAULT NULL
        )');

        $db->insert('users', ['username' => 'player1', 'money' => 500, 'level' => 3]);

        $container->set('db', $db);
        $container->set('config', ['url' => 'http://test/', 'max_tasks' => 3]);
        $container->set('user', ['id' => 1, 'username' => 'player1', 'tasks' => 0, 'level' => 3]);

        // Lazy factories — exactly as index.php registers them
        $container->factory('uclass', function (Container $c) {
            return new UserClass($c);
        });
        $container->factory('taskclass', function (Container $c) {
            return new Tasks($c);
        });

        return $container;
    }

    // ------------------------------------------------------------------
    // Full composition root simulation
    // ------------------------------------------------------------------

    public function testFullWiringProducesWorkingServices(): void
    {
        $c = $this->buildContainer();

        // Access services — factories fire on first use
        $uclass    = $c->uclass();
        $taskclass = $c->taskclass();

        $this->assertInstanceOf(UserClass::class, $uclass);
        $this->assertInstanceOf(Tasks::class, $taskclass);
    }

    public function testServicesCanPerformDatabaseOperations(): void
    {
        $c = $this->buildContainer();

        // UserClass reads from DB
        $uclass = $c->uclass();
        $premium = $uclass->getPremiumData(1);
        $this->assertArrayHasKey('id', $premium);

        // Tasks writes/reads from DB
        $taskclass = $c->taskclass();
        $user = $c->get('user');
        $taskclass->add_task_session($user['id'], 15, 600, ['q' => 1], 1, 'Mission X');
        $task = $taskclass->check_fetch_task($user, 15);
        $this->assertNotFalse($task);
        $this->assertSame('Mission X', $task['name']);
    }

    public function testErrorsPropagateAcrossAllServices(): void
    {
        $c = $this->buildContainer();

        // Simulate errors being added from different services
        $c->uclass()->errors[] = 'Error from UserClass';
        $c->taskclass()->errors[] = 'Error from Tasks';
        $c->errors[] = 'Error from module code';

        $this->assertCount(3, $c->errors);
    }

    public function testMultipleContainersAreIndependent(): void
    {
        $c1 = $this->buildContainer();
        $c2 = $this->buildContainer();

        $c1->errors[] = 'only in c1';
        $c2->errors[] = 'only in c2';

        $this->assertCount(1, $c1->errors);
        $this->assertCount(1, $c2->errors);
        $this->assertContains('only in c1', $c1->errors);
        $this->assertContains('only in c2', $c2->errors);
    }

    public function testContainerStateIsIsolatedPerRequest(): void
    {
        $c = $this->buildContainer();

        // Simulate a request lifecycle
        $c->logged = true;
        $c->GET = ['currentPage' => 'quests'];
        $c->tVars['display'] = 'pages/quests.tpl';
        $c->success[] = 'Quest completed!';

        $this->assertTrue($c->logged);
        $this->assertSame('quests', $c->GET['currentPage']);
        $this->assertSame('pages/quests.tpl', $c->tVars['display']);
        $this->assertCount(1, $c->success);

        // New container = clean state
        $c2 = $this->buildContainer();
        $this->assertFalse($c2->logged);
        $this->assertEmpty($c2->tVars);
        $this->assertEmpty($c2->success);
    }

    public function testLazyFactoryDoesNotFireUntilNeeded(): void
    {
        $c = new Container();
        $c->set('db', new \stdClass());
        $c->set('config', []);
        $c->set('user', []);

        $factoryFired = false;
        $c->factory('uclass', function () use (&$factoryFired) {
            $factoryFired = true;
            return new \stdClass();
        });

        // Just checking existence should not fire
        $this->assertTrue($c->has('uclass'));
        $this->assertFalse($factoryFired);

        // Accessing the service fires it
        $c->uclass();
        $this->assertTrue($factoryFired);
    }

    public function testAddRewardAndTaskIntegration(): void
    {
        $c = $this->buildContainer();

        $uclass    = $c->uclass();
        $taskclass = $c->taskclass();
        $user      = $c->get('user');

        // Create a task
        $taskclass->add_task_session($user['id'], 15, 120, [], null, 'Integration Quest');

        // Create a reward
        $rewardId = $uclass->addReward($user['id'], ['money' => 100, 'exp' => 50], 'Quest Completion');

        // Verify both exist in DB
        $db = $c->db();
        $task = $db->where('uid', $user['id'])->where('type', 15)->getOne('tasks');
        $this->assertSame('Integration Quest', $task['name']);

        $reward = $db->where('reward_id', $rewardId)->getOne('user_rewards');
        $this->assertSame('Quest Completion', $reward['title']);
    }
}
