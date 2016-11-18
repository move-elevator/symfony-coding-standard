<?php

/**
 * Symfony2_Sniffs_Formatting_BlankLineBeforeNamespaceSniff.
 *
 * Throws errors if there's no blank line before namespace
 */
class Symfony2_Sniffs_Formatting_BlankLineBeforeNamespaceSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = ['PHP'];

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_NAMESPACE];
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
        $current = $stackPtr;
        $previousLines = $tokens[$stackPtr]['line'] - 2;
        $prevLineTokens = array();

        while ($previousLines <= $current) {
            $current--;

            if (0 <= $current) {
                $prevLineTokens[] = $tokens[$current]['type'];
            }
        }

        if ('T_WHITESPACE' === $prevLineTokens[0] && 'T_SEMICOLON' === $prevLineTokens[1] && in_array('T_DECLARE', $prevLineTokens)) {
            $phpcsFile->addError(
                'Missing blank line between declare-command and namespace',
                $stackPtr
            );

            return;
        }

        if ('T_OPEN_TAG' === $prevLineTokens[0] || 'T_WHITESPACE' !== $prevLineTokens[0] ) {
            $phpcsFile->addError(
                'Missing blank line between opening tag and namespace',
                $stackPtr
            );

            return;
        }


        return;
    }
}
