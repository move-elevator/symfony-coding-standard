<?php

/**
 * Throws errors if interface names are not suffixed with "Interface".
 */
class Symfony2_Sniffs_NamingConventions_InterfaceSuffixSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
        'PHP',
    );

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_INTERFACE);
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
        $tokens = $phpcsFile->getTokens();
        $line = $tokens[$stackPtr]['line'];

        while ($tokens[$stackPtr]['line'] == $line) {

            if ('T_STRING' !== $tokens[$stackPtr]['type']) {
                $stackPtr++;
                continue;
            }

            if (substr($tokens[$stackPtr]['content'], -9) != 'Interface') {
                $phpcsFile->addError('Interface name is not suffixed with "Interface"', $stackPtr);
                break;
            }

            $stackPtr++;
        }

        return;
    }
}

