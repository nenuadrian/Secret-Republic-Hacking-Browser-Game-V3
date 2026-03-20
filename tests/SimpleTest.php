<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class/Container.php';

final class SimpleTest extends TestCase
{
    public function testPushAndPop(): void
    {
        global $container;
        $container = new Container();
        $container->errors = [];

        require_once './includes/functions.php';
        $this->assertSame(false, there_are_errors());

        $container->errors[] = 'dsf';

        $this->assertSame(true, there_are_errors());
    }
}
