<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class TutorialTest extends TestCase
{
    public function testConstants(): void
    {
        define('URL', 'URL');
        $user = [
            'username' => 'test'
        ];
        require './includes/constants/tutorial.php';
        $this->assertSame(18, count($tutorialSteps));
        for ($i = 1; $i <= count($tutorialSteps); $i++) {
            $functionName = "tutorial_step_" . $i . "_check";
            $this->assertSame(true, function_exists($functionName));
        }
    }
}