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
        $this->assertNotNull($this->executeCodeSniffer($file));
    }

    /**
     * @covers Symfony2_Sniffs_Commenting_FunctionCommentSniff
     */
    public function testReturnTagAnnotation()
    {
        $file = realpath(__DIR__ . '/../../Fixtures/Commenting/FunctionCommentSniff/Good.php');
        $this->assertNull($this->executeCodeSniffer($file));
    }

    /**
     * @param string $file
     *
     * @return string
     */
    private function executeCodeSniffer($file)
    {
        $this->processBuilder
            ->add('--sniffs=Symfony2.Commenting.FunctionComment')
            ->add($file);

        $process = $this->processBuilder->getProcess();
        $process->run();

        return $process->getOutput();
    }
}
