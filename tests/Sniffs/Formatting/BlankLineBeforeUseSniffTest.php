<?php

namespace MoveElevator\CodingStandard\Tests\Sniffs\Formatting;

use MoveElevator\CodingStandard\Tests\PhpcsTestCase;

class BlankLineBeforeUseSniffTest extends PhpcsTestCase
{
    /**
     * @covers Symfony2_Sniffs_Formatting_BlankLineBeforeUseSniff
     */
    public function testBlankLineBeforeUse()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/BlankLineBeforeUse/Good.php');
        $this->assertEquals(0, $this->sniffFile($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_BlankLineBeforeUseSniff
     */
    public function testBlankLineBeforeUseFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/BlankLineBeforeUse/Bad.php');
        $this->assertEquals(1, $this->sniffFile($file));
    }
}