<?php

namespace MoveElevator\CodingStandard\Tests\Sniffs\Commenting;

use MoveElevator\CodingStandard\Tests\PhpcsTestCase;

/**
 * Class FunctionCommentSniffTest
 */
class FunctionCommentSniffTest extends PhpcsTestCase
{
    /**
     * @covers Symfony2_Sniffs_Commenting_FunctionCommentSniff
     */
    public function testReturnTagAnnotationFailures()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Commenting/FunctionCommentSniff/Bad.php');
        $this->assertNotEquals(0, $this->sniffFileForErrors($file));
    }

    /**
     * @covers Symfony2_Sniffs_Commenting_FunctionCommentSniff
     */
    public function testReturnTagAnnotation()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Commenting/FunctionCommentSniff/Good.php');
        $this->assertEquals(0, $this->sniffFileForErrors($file));
    }
}
