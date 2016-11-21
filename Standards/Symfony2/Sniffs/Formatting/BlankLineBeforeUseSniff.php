<?php

class Symfony2_Sniffs_Formatting_BlankLineBeforeUseSniff implements PHP_CodeSniffer_Sniff
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
        return [T_USE];
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

        $previousUse = $phpcsFile->findPrevious([T_USE], $current-1, null);
        if ($previousUse) {
            return;
        }

        if ('T_WHITESPACE' === $tokens[$current - 1]['type'] && 'T_WHITESPACE' !== $tokens[$current - 2]['type']) {
            $phpcsFile->addError(
                'Missing blank line between use statements and namespace',
                $current
            );

            return;
        }
    }
}
