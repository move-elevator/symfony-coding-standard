<?php

/**
 * Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff.
 *
 * Throws errors if there's a blank line before first method
 */
class Symfony2_Sniffs_Formatting_NoBlankLineBeforeFirstMethodCommentSniff implements PHP_CodeSniffer_Sniff
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

        $openingBrace = $phpcsFile->findNext([T_OPEN_CURLY_BRACKET], $current, null);
        $firstMethodComment = $phpcsFile->findNext([T_DOC_COMMENT_OPEN_TAG], $openingBrace);

        if ($tokens[$openingBrace]['line'] > $tokens[$firstMethodComment]['line']) {
            return;
        }

        $elementToCheck = $firstMethodComment;
        $trait = $phpcsFile->findPrevious(T_USE, $firstMethodComment);

        if (true === is_int($trait)) {
            $elementToCheck = $trait;
        }

        $constant = $phpcsFile->findNext([T_CONST], $openingBrace);
        $use = $phpcsFile->findNext([T_USE], $openingBrace, $firstMethodComment);

        if (false !== $constant && $constant > $openingBrace && $constant < $firstMethodComment) {
            $elementBeforeConstant = $phpcsFile->findPrevious([T_WHITESPACE], $openingBrace, $constant, true);

            if (false != $use && ($tokens[$openingBrace]['line'] + 1) !== $tokens[$use]['line']) {
                $phpcsFile->addWarning('Remove blank line before use Statement', $use);
            }

            if (false === $use && false === $elementBeforeConstant && ($tokens[$openingBrace]['line'] + 1) != $tokens[$constant]['line']) {
                $phpcsFile->addWarning('Remove blank line before const Statement', $constant);
            }

            if ($use != false && ($tokens[$phpcsFile->findPrevious([T_USE], $constant, $openingBrace)]['line'] + 2) !== $tokens[$constant]['line']) {
                $phpcsFile->addWarning('Only one blank line before constant statement is allowed', $constant);
            }

            return;
        }

        if (1 < ($tokens[$elementToCheck]['line'] - $tokens[$openingBrace]['line'])) {
            $phpcsFile->addWarning('Remove blank line before.', $elementToCheck);
        }
    }
}
