<?php

/**
 * Symfony2_Sniffs_Formatting_BlankLineBeforeNamespaceSniff.
 *
 * Throws errors if there's no blank line before class comment
 */
class Symfony2_Sniffs_Formatting_BlankLineBeforeClassCommentSniff implements PHP_CodeSniffer_Sniff
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
        return [T_CLASS];
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

        while ($current > 0) {
            $current--;

            if ('T_DOC_COMMENT_OPEN_TAG' !== $tokens[$current]['type']) {
                continue;
            }

            if (false === $phpcsFile->findPrevious([T_USE], $current, null)) {
                return;
            }

            if ('T_WHITESPACE' !== $tokens[$current - 2]['type']) {
                $phpcsFile->addWarning(
                    'Missing blank line between class doc comment and use statements',
                    $current
                );

                return;
            }
        }
    }
}
