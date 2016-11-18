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
        $this->assertEquals(0, $this->sniffFileForErrors($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testConstantInClassDoesNotThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Good2.php');
        $this->assertEquals(0, $this->sniffFileForErrors($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testConstantBeforeFirstClassComment()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Good3.php');
        $this->assertEquals(0, $this->sniffFileForErrors($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testBlankLineBeforeMethodCommentThrowsFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Bad.php');
        $this->assertNotEquals(0, $this->sniffFileForErrors($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testBlankLineBeforeTraitUsageThrowsFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Bad2.php');
        $this->assertNotEquals(0, $this->sniffFileForErrors($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff
     */
    public function testBlankLineBeforeConstantStatementFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/NoBlankLineBeforeFirstMethodCommentSniff/Bad3.php');
        $this->assertNotEquals(0, $this->sniffFileForErrors($file));
    }
}
