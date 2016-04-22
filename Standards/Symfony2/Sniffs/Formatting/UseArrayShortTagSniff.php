<?php

/**
 * This file is part of the mo4-coding-standard (phpcs standard)
 *
 * Use Array Short Tag sniff.
 *
 * Use the array short tag [...] instead of array(...)
 *
 * @category  PHP
 * @package   PHP_CodeSniffer-MO4
 * @author    Xaver Loppenstedt <xaver@loppenstedt.de>
 * @copyright 2013 Xaver Loppenstedt, some rights reserved.
 * @license   http://spdx.org/licenses/MIT MIT License
 * @link      https://github.com/Mayflower/mo4-coding-standard
 */
class Symfony2_Sniffs_Formatting_UseArrayShortTagSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [T_ARRAY];
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile All the tokens found in the document.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $fix = $phpcsFile->addFixableError('Array short tag [ ... ] must be used', $stackPtr, 'NoShortTagUsed');
        if ($fix === true) {
            $tokens = $phpcsFile->getTokens();
            $token = $tokens[$stackPtr];
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($stackPtr, '');
            $phpcsFile->fixer->replaceToken($token['parenthesis_opener'], '[');

            for ($i = ($stackPtr + 1); $i < $token['parenthesis_opener']; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }

            $phpcsFile->fixer->replaceToken($token['parenthesis_closer'], ']');
            $phpcsFile->fixer->endChangeset();
        }
    }
}