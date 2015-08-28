<?php

namespace MoveElevator\CodingStandard\Tests\Sniffs\Formatting;

use MoveElevator\CodingStandard\Tests\PhpcsTestCase;

/**
 * Class NoBlankLineBeforeFirstMethodCommentSniffTest
 */
class NoBlankLineBeforeFirstMethodCommentSniffTest extends PhpcsTestCase
{
    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testTraitUsageInClassDoesNotThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Good.php');
        $this->assertNull($this->executeCodeSniffer($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testConstantInClassDoesNotThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Good2.php');
        $this->assertNull($this->executeCodeSniffer($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testConstantBeforeFirstClassComment()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Good3.php');
        $this->assertNull($this->executeCodeSniffer($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testBlankLineBeforeMethodCommentThrowsFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Bad.php');
        $this->assertNotNull($this->executeCodeSniffer($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testBlankLineBeforeTraitUsageThrowsFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Bad2.php');
        $this->assertNotNull($this->executeCodeSniffer($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testBlankLineBeforeConstantStatementFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Bad3.php');
        $this->assertNotNull($this->executeCodeSniffer($file));
    }

    /**
     * @param string $file
     *
     * @return string
     */
    private function executeCodeSniffer($file)
    {
        $this->processBuilder
            ->add('--sniffs=Symfony2.Formatting.NoBlankLineBeforeFirstMethodComment')
            ->add($file);

        $process = $this->processBuilder->getProcess();
        $process->run();

        return $process->getOutput();
    }
}
