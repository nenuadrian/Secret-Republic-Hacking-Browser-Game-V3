<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/Container.php';
require_once __DIR__ . '/../includes/functions.php';

/**
 * Tests that global utility functions (functions.php) properly read/write
 * through the Container instead of bare globals.
 */
final class FunctionsContainerTest extends TestCase
{
    private Container $originalContainer;

    protected function setUp(): void
    {
        global $container;
        // Save any existing container to restore later
        $this->originalContainer = $container ?? new Container();

        $container = new Container();
        $container->set('config', [
            'url' => 'http://test.local/',
        ]);
        $container->set('user', ['id' => 1]);
    }

    protected function tearDown(): void
    {
        global $container;
        $container = $this->originalContainer;
    }

    // ------------------------------------------------------------------
    // there_are_errors / add_alert
    // ------------------------------------------------------------------

    public function testThereAreErrorsReadFromContainer(): void
    {
        global $container;
        $container->errors = [];
        $this->assertFalse(there_are_errors());

        $container->errors[] = 'boom';
        $this->assertTrue(there_are_errors());
    }

    public function testAddAlertErrorWritesToContainer(): void
    {
        global $container;
        $container->errors = [];
        add_alert('something broke');
        $this->assertContains('something broke', $container->errors);
    }

    public function testAddAlertSuccessWritesToContainer(): void
    {
        global $container;
        $container->success = [];
        add_alert('well done', 'success');
        $this->assertContains('well done', $container->success);
    }

    // ------------------------------------------------------------------
    // logged_in
    // ------------------------------------------------------------------

    public function testLoggedInReadsFromContainer(): void
    {
        global $container;
        $container->logged = false;
        $this->assertFalse(logged_in());

        $container->logged = true;
        $this->assertTrue(logged_in());
    }

    // ------------------------------------------------------------------
    // GET()
    // ------------------------------------------------------------------

    public function testGETReadsFromContainer(): void
    {
        global $container;
        $container->GET = ['currentPage' => 'quests', 'alpha' => '1'];

        $this->assertSame('quests', GET('currentPage'));
        $this->assertSame('1', GET('alpha'));
        $this->assertFalse(GET('nonexistent'));
    }

    // ------------------------------------------------------------------
    // configs()
    // ------------------------------------------------------------------

    public function testConfigsReadsFromContainer(): void
    {
        global $container;
        $container->set('config', ['url' => 'http://x/', 'max_tasks' => 5]);

        $this->assertSame('http://x/', configs('url'));
        $this->assertSame(5, configs('max_tasks'));
        $this->assertFalse(configs('no_such_key'));
    }

    // ------------------------------------------------------------------
    // profile_link
    // ------------------------------------------------------------------

    public function testProfileLinkUsesConfigFromContainer(): void
    {
        global $container;
        $container->set('config', ['url' => 'http://game.test/']);

        $link = profile_link('neo');
        $this->assertStringContainsString('http://game.test/profile/hacker/neo', $link);
        $this->assertStringContainsString('neo', $link);
    }

    // ------------------------------------------------------------------
    // Pure utility functions still work (no container dependency)
    // ------------------------------------------------------------------

    public function testSec2hms(): void
    {
        $this->assertSame('01:30:00', sec2hms(5400));
        $this->assertSame('00:01:05', sec2hms(65));
    }

    public function testRomanicNumber(): void
    {
        $this->assertSame('IV', romanic_number(4));
        $this->assertSame('IX', romanic_number(9));
        $this->assertSame('XLII', romanic_number(42));
    }

    public function testOrdinal(): void
    {
        $this->assertSame('1st', ordinal(1));
        $this->assertSame('2nd', ordinal(2));
        $this->assertSame('3rd', ordinal(3));
        $this->assertSame('11th', ordinal(11));
        $this->assertSame('21st', ordinal(21));
    }

    public function testIsIp(): void
    {
        $this->assertNotFalse(is_ip('192.168.1.1'));
        $this->assertFalse(is_ip('not-an-ip'));
    }

    public function testGenerateIps(): void
    {
        $ips = generate_ips(5);
        $this->assertCount(5, $ips);
        foreach ($ips as $ip) {
            $this->assertNotFalse(filter_var($ip, FILTER_VALIDATE_IP));
        }
    }

    public function testSubmittedFormReturnsFalseWhenNoPost(): void
    {
        $_POST = [];
        $this->assertFalse(submitted_form('test'));
    }

    public function testSubmittedFormReturnsTrueWhenMatches(): void
    {
        $_POST = ['form_identifier' => 'myform'];
        $this->assertTrue(submitted_form('myform'));
    }
}
