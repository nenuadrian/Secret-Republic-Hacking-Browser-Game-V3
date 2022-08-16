<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class SkillsTest extends TestCase
{
    public function testConstants(): void
    {
        require './includes/constants/skills.php';
        $this->assertSame(16, count($theskills));
    }
}