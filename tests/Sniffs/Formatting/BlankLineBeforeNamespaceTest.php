<?php
declare(strict_types = 1);

namespace MoveElevator\CodingStandard\Tests\Sniffs\Formatting;

use MoveElevator\CodingStandard\Tests\PhpcsTestCase;

class BlankLineBeforeNamespaceTest extends PhpcsTestCase
{
    /**
     * @covers \Symfony2_Sniffs_Formatting_BlankLineBeforeNamespaceSniff
     */
    public function testBlankLineBeforeNamespaceNotThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/BlankLineBeforeNamespace/Good.php');
        $this->assertEquals(0, $this->sniffFileForWarnings($file));
    }

    /**
     * @covers \Symfony2_Sniffs_Formatting_BlankLineBeforeNamespaceSniff
     */
    public function testBlankLineBeforeNamespaceThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/BlankLineBeforeNamespace/Bad.php');

        $this->assertEquals(1, $this->sniffFileForWarnings($file));
    }

    /**
     * @covers \Symfony2_Sniffs_Formatting_BlankLineBeforeNamespaceSniff
     */
    public function testBlankLineBeforeNamespaceWithoutDeclareNotThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/BlankLineBeforeNamespace/Good2.php');

        $this->assertEquals(0, $this->sniffFileForWarnings($file));
    }

    /**
     * @covers \Symfony2_Sniffs_Formatting_BlankLineBeforeNamespaceSniff
     */
    public function testBlankLineBeforeNamespaceWithoutDeclareThrowFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Formatting/BlankLineBeforeNamespace/Bad2.php');

        $this->assertEquals(1, $this->sniffFileForWarnings($file));
    }
}