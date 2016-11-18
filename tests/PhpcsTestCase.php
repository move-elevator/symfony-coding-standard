<?php

namespace MoveElevator\CodingStandard\Tests;

/**
 * Class PhpcsTestCase
 */
abstract class PhpcsTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $file string
     *
     * @return int ErrorCount
     */
    protected function sniffFileForErrors($file)
    {
        $phpCs = new \PHP_CodeSniffer();
        $phpCs->initStandard(realpath(__DIR__ . '/../Standards/Symfony2'));

        $result = $phpCs->processFile($file);
        $errors = $result->getErrorCount();

        return $errors;
    }

    /**
     * @param $file string
     *
     * @return int WarningCount
     */
    protected function sniffFileForWarnings($file)
    {
        $phpCs = new \PHP_CodeSniffer();
        $phpCs->initStandard(realpath(__DIR__ . '/../Standards/Symfony2'));

        $result = $phpCs->processFile($file);
        $warnings = $result->getWarningCount();

        return $warnings;
    }
}
