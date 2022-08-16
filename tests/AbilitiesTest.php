<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class AbilitiesTest extends TestCase
{
    public function testConstants(): void
    {
        require './includes/constants/abilities.php';
        $test = abilities([], []);
        $this->assertSame(8, count($test));
    }
}