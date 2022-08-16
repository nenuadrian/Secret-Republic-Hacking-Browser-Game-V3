<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class AbilitiesTest extends TestCase
{
    public function testConstants(): void
    {
        require './includes/constants/abilities.php';
        $test = abilities([
            1 => 1,
            2 => 1,
            3 => 1,
            5 => 1,
            4 => 1,
            6 => 1,
            7 => 1,
            8 => 2
        ], [
            'maxEnergy' => 10
        ]);
        $this->assertSame(8, count($test));
    }
}