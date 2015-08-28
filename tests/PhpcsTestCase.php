<?php

namespace MoveElevator\CodingStandard\Tests;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PhpcsTestCase
 */
abstract class PhpcsTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProcessBuilder
     */
    protected $processBuilder;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $binary = realpath(__DIR__ . '/../vendor/bin/phpcs');
        $standard = realpath(__DIR__ . '/../Standards/Symfony2');

        $processBuilder = new ProcessBuilder;
        $processBuilder
            ->add($binary)
            ->add('--standard=' . $standard);

        $this->processBuilder = $processBuilder;
    }
}
