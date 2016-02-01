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
        $processBuilder = new ProcessBuilder;
        $processBuilder
            ->add(realpath(__DIR__ . '/../vendor/bin/phpcs'))
            ->add('--standard=' . realpath(__DIR__ . '/../Standards/Symfony2'));

        $this->processBuilder = $processBuilder;
    }
}
