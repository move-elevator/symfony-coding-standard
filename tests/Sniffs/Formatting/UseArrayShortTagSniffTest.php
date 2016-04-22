<?php

namespace MoveElevator\CodingStandard\Tests\Sniffs\Formatting;

use MoveElevator\CodingStandard\Tests\PhpcsTestCase;

/**
 * Class UseArrayShortTagSniffTest
 */
class UseArrayShortTagSniffTest extends PhpcsTestCase
{
    /**
     * @covers Symfony2_Sniffs_Formatting_UseArrayShortTagSniff
     */
    public function testUseArrayShortTagNotThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/UseArrayShortTagSniff/Good.php');
        $this->assertEquals(0, $this->sniffFile($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_UseArrayShortTagSniff
     */
    public function testUseArrayOldTagThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/UseArrayShortTagSniff/Bad.php');

        $this->assertEquals(2, $this->sniffFile($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_UseArrayShortTagSniff
     */
    public function testUseArrayShortTagMultilineNotThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/UseArrayShortTagSniff/Good2.php');
        $this->assertEquals(0, $this->sniffFile($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_UseArrayShortTagSniff
     */
    public function testUseArrayOldTagMultilineThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/UseArrayShortTagSniff/Bad2.php');

        $this->assertEquals(2, $this->sniffFile($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_UseArrayShortTagSniff
     */
    public function testUseArrayShortTagAssicativeNotThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/UseArrayShortTagSniff/Good3.php');
        $this->assertEquals(0, $this->sniffFile($file));
    }

    /**
     * @covers Symfony2_Sniffs_Formatting_UseArrayShortTagSniff
     */
    public function testUseArrayOldTagAssociativeThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/UseArrayShortTagSniff/Bad3.php');

        $this->assertEquals(1, $this->sniffFile($file));
    }
}