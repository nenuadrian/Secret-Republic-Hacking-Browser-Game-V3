<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class SimpleTest extends TestCase
{
    public function testPushAndPop(): void
    {
        global $errors;
        $errors = [];
        
        require './includes/functions.php';
        $this->assertSame(false, there_are_errors());

        $errors[] = 'dsf';

        $this->assertSame(true, there_are_errors());
    }
}