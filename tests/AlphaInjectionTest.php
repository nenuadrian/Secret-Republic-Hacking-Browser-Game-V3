<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/Container.php';
require_once __DIR__ . '/../includes/class/alpha.class.php';

/**
 * Tests that the Alpha base class correctly reads/writes through the Container
 * instead of pulling from PHP globals.
 */
final class AlphaInjectionTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
        // Provide minimal services so Alpha doesn't blow up
        $this->container->set('db', new \stdClass());
        $this->container->set('config', ['url' => 'http://test/', 'recaptcha_site_key' => '', 'recaptcha_secret_key' => '']);
        $this->container->set('user', ['id' => 1, 'username' => 'testuser']);
        $this->container->set('uclass', new \stdClass());
        $this->container->set('taskclass', new \stdClass());
    }

    private function makeAlpha(): Alpha
    {
        return new Alpha($this->container);
    }

    // ------------------------------------------------------------------
    // Reading container state through Alpha property access
    // ------------------------------------------------------------------

    public function testDbAccessThroughAlpha(): void
    {
        $db = new \stdClass();
        $db->tag = 'test-db';
        $this->container->set('db', $db);

        $alpha = $this->makeAlpha();
        $this->assertSame('test-db', $alpha->db->tag);
    }

    public function testConfigAccessThroughAlpha(): void
    {
        $this->container->set('config', ['url' => 'http://example.com/']);
        $alpha = $this->makeAlpha();
        $this->assertSame('http://example.com/', $alpha->config['url']);
    }

    public function testUserAccessThroughAlpha(): void
    {
        $this->container->set('user', ['id' => 99, 'username' => 'hacker']);
        $alpha = $this->makeAlpha();
        $this->assertSame(99, $alpha->user['id']);
    }

    public function testLoggedAccessThroughAlpha(): void
    {
        $this->container->logged = true;
        $alpha = $this->makeAlpha();
        $this->assertTrue($alpha->logged);
    }

    // ------------------------------------------------------------------
    // Writing through Alpha updates the container
    // ------------------------------------------------------------------

    public function testWritingErrorsThroughAlphaUpdatesContainer(): void
    {
        $alpha = $this->makeAlpha();
        $alpha->errors[] = 'test error';
        $this->assertContains('test error', $this->container->errors);
    }

    public function testWritingSuccessThroughAlphaUpdatesContainer(): void
    {
        $alpha = $this->makeAlpha();
        $alpha->success[] = 'yay';
        $this->assertContains('yay', $this->container->success);
    }

    public function testWritingVoiceThroughAlphaUpdatesContainer(): void
    {
        $alpha = $this->makeAlpha();
        $alpha->voice = 'accessgranted';
        $this->assertSame('accessgranted', $this->container->voice);
    }

    public function testWritingTemplateVariablesThroughAlphaUpdatesContainer(): void
    {
        $alpha = $this->makeAlpha();
        $alpha->templateVariables['display'] = 'pages/test.tpl';
        $this->assertSame('pages/test.tpl', $this->container->tVars['display']);
    }

    public function testWritingLoggedThroughAlphaUpdatesContainer(): void
    {
        $alpha = $this->makeAlpha();
        $alpha->logged = true;
        $this->assertTrue($this->container->logged);
    }

    // ------------------------------------------------------------------
    // Two Alpha instances share state through the same container
    // ------------------------------------------------------------------

    public function testTwoAlphaInstancesShareErrors(): void
    {
        $a1 = $this->makeAlpha();
        $a2 = $this->makeAlpha();

        $a1->errors[] = 'from a1';
        $this->assertContains('from a1', $a2->errors);
    }

    public function testTwoAlphaInstancesShareUser(): void
    {
        $a1 = $this->makeAlpha();
        $a2 = $this->makeAlpha();

        $this->container->set('user', ['id' => 7, 'username' => 'shared']);
        $this->assertSame(7, $a1->user['id']);
        $this->assertSame(7, $a2->user['id']);
    }

    public function testTwoAlphaInstancesShareTemplateVars(): void
    {
        $a1 = $this->makeAlpha();
        $a2 = $this->makeAlpha();

        $a1->templateVariables['key'] = 'value';
        $this->assertSame('value', $a2->templateVariables['key']);
    }

    // ------------------------------------------------------------------
    // Dynamic properties for subclass-specific data
    // ------------------------------------------------------------------

    public function testDynamicPropertiesAreIsolatedPerInstance(): void
    {
        $a1 = $this->makeAlpha();
        $a2 = $this->makeAlpha();

        $a1->customProp = 'only-a1';
        // a2 should not see a1's custom prop
        $this->assertNull($a2->customProp);
    }

    // ------------------------------------------------------------------
    // Isset checks
    // ------------------------------------------------------------------

    public function testIssetForMappedProperties(): void
    {
        $alpha = $this->makeAlpha();
        $this->assertTrue(isset($alpha->db));
        $this->assertTrue(isset($alpha->config));
        $this->assertTrue(isset($alpha->user));
        $this->assertTrue(isset($alpha->errors));
        $this->assertTrue(isset($alpha->logged));
        $this->assertTrue(isset($alpha->uclass));
        $this->assertTrue(isset($alpha->taskclass));
    }

    // ------------------------------------------------------------------
    // show_404 writes through container
    // ------------------------------------------------------------------

    public function testShow404SetsVoiceAndTemplateVar(): void
    {
        $alpha = $this->makeAlpha();
        $alpha->show_404();

        $this->assertSame('404', $this->container->voice);
        $this->assertTrue($this->container->tVars['show_404']);
    }

    // ------------------------------------------------------------------
    // addMessenger writes through container
    // ------------------------------------------------------------------

    public function testAddMessengerAppendsToContainer(): void
    {
        $alpha = $this->makeAlpha();
        $alpha->addMessenger('hello', 'info');

        $this->assertCount(1, $this->container->messenger);
        $this->assertSame('hello', $this->container->messenger[0]['message']);
        $this->assertSame('info', $this->container->messenger[0]['type']);
    }

    public function testAddMessengerWithoutType(): void
    {
        $alpha = $this->makeAlpha();
        $alpha->addMessenger('no type');

        $this->assertCount(1, $this->container->messenger);
        $this->assertSame('no type', $this->container->messenger[0]['message']);
        $this->assertArrayNotHasKey('type', $this->container->messenger[0]);
    }
}
