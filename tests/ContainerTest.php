<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/Container.php';

/**
 * Tests the DI Container class in isolation.
 */
final class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    // ------------------------------------------------------------------
    // Service registration & retrieval
    // ------------------------------------------------------------------

    public function testSetAndGet(): void
    {
        $this->container->set('foo', 'bar');
        $this->assertSame('bar', $this->container->get('foo'));
    }

    public function testHasReturnsTrueForRegisteredService(): void
    {
        $this->container->set('x', 123);
        $this->assertTrue($this->container->has('x'));
    }

    public function testHasReturnsFalseForUnknownService(): void
    {
        $this->assertFalse($this->container->has('nonexistent'));
    }

    public function testGetThrowsForUnknownService(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Service not found in container: missing');
        $this->container->get('missing');
    }

    // ------------------------------------------------------------------
    // Lazy factories
    // ------------------------------------------------------------------

    public function testFactoryIsCalledLazily(): void
    {
        $called = false;
        $this->container->factory('lazy', function () use (&$called) {
            $called = true;
            return 'result';
        });

        $this->assertFalse($called, 'Factory should not be called at registration time');
        $this->assertSame('result', $this->container->get('lazy'));
        $this->assertTrue($called);
    }

    public function testFactoryResultIsCached(): void
    {
        $callCount = 0;
        $this->container->factory('singleton', function () use (&$callCount) {
            $callCount++;
            return new \stdClass();
        });

        $first  = $this->container->get('singleton');
        $second = $this->container->get('singleton');

        $this->assertSame(1, $callCount, 'Factory must only be invoked once');
        $this->assertSame($first, $second, 'Same instance must be returned');
    }

    public function testFactoryReceivesContainer(): void
    {
        $this->container->set('greeting', 'hello');
        $this->container->factory('message', function (Container $c) {
            return $c->get('greeting') . ' world';
        });

        $this->assertSame('hello world', $this->container->get('message'));
    }

    public function testHasReturnsTrueForFactory(): void
    {
        $this->container->factory('deferred', function () { return 1; });
        $this->assertTrue($this->container->has('deferred'));
    }

    // ------------------------------------------------------------------
    // Convenience accessors
    // ------------------------------------------------------------------

    public function testDbAccessor(): void
    {
        $mock = new \stdClass();
        $this->container->set('db', $mock);
        $this->assertSame($mock, $this->container->db());
    }

    public function testConfigAccessor(): void
    {
        $cfg = ['url' => 'http://test'];
        $this->container->set('config', $cfg);
        $this->assertSame($cfg, $this->container->config());
    }

    public function testUserAccessor(): void
    {
        $user = ['id' => 42, 'username' => 'hacker'];
        $this->container->set('user', $user);
        $this->assertSame($user, $this->container->user());
    }

    public function testUclassAccessor(): void
    {
        $mock = new \stdClass();
        $this->container->set('uclass', $mock);
        $this->assertSame($mock, $this->container->uclass());
    }

    public function testTaskclassAccessor(): void
    {
        $mock = new \stdClass();
        $this->container->set('taskclass', $mock);
        $this->assertSame($mock, $this->container->taskclass());
    }

    public function testSmartyAccessor(): void
    {
        $mock = new \stdClass();
        $this->container->set('smarty', $mock);
        $this->assertSame($mock, $this->container->smarty());
    }

    // ------------------------------------------------------------------
    // Request-scoped mutable state
    // ------------------------------------------------------------------

    public function testRequestStateDefaults(): void
    {
        $c = new Container();
        $this->assertSame([], $c->tVars);
        $this->assertSame([], $c->errors);
        $this->assertSame([], $c->success);
        $this->assertSame([], $c->info);
        $this->assertSame([], $c->warnings);
        $this->assertSame([], $c->messenger);
        $this->assertSame([], $c->myModals);
        $this->assertSame('', $c->voice);
        $this->assertFalse($c->logged);
        $this->assertSame([], $c->GET);
        $this->assertSame('', $c->url);
        $this->assertNull($c->pages);
    }

    public function testErrorsCanBeAppended(): void
    {
        $this->container->errors[] = 'first error';
        $this->container->errors[] = 'second error';
        $this->assertCount(2, $this->container->errors);
        $this->assertSame('first error', $this->container->errors[0]);
    }

    public function testSuccessCanBeAppended(): void
    {
        $this->container->success[] = 'it worked';
        $this->assertCount(1, $this->container->success);
    }

    public function testTVarsCanBeSet(): void
    {
        $this->container->tVars['display'] = 'pages/test.tpl';
        $this->assertSame('pages/test.tpl', $this->container->tVars['display']);
    }

    public function testGETCanBeSet(): void
    {
        $this->container->GET['currentPage'] = 'quests';
        $this->assertSame('quests', $this->container->GET['currentPage']);
    }

    public function testLoggedState(): void
    {
        $this->assertFalse($this->container->logged);
        $this->container->logged = true;
        $this->assertTrue($this->container->logged);
    }

    // ------------------------------------------------------------------
    // Overwriting services
    // ------------------------------------------------------------------

    public function testSetOverwritesPreviousValue(): void
    {
        $this->container->set('db', 'old');
        $this->container->set('db', 'new');
        $this->assertSame('new', $this->container->get('db'));
    }

    public function testSetOverwritesFactory(): void
    {
        $this->container->factory('svc', function () { return 'from-factory'; });
        $this->container->set('svc', 'from-set');
        $this->assertSame('from-set', $this->container->get('svc'));
    }
}
