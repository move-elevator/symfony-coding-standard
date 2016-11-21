<?php

namespace MoveElevator\CodingStandard\Tests\Sniffs\Formatting;

use MoveElevator\CodingStandard\Tests\PhpcsTestCase;

class BlankLineBeforeClassSniffTest extends PhpcsTestCase
{
    /**
     * @covers Symfony2_Sniffs_Formatting_BlankLineBeforeClassSniff
     */
    public function testBlankLineBeforeClass()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/BlankLineBeforeClass/Good.php');
        $this->assertEquals(0, $this->sniffFile($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_BlankLineBeforeClassSniff
     */
    public function testBlankLineBeforeClassFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/BlankLineBeforeClass/Bad.php');
        $this->assertNotEquals(0, $this->sniffFile($file));
    }
}