<?php

if (class_exists('PEAR_Sniffs_Commenting_FunctionCommentSniff', true) === false) {
    $error = 'Class PEAR_Sniffs_Commenting_FunctionCommentSniff not found';
    throw new PHP_CodeSniffer_Exception($error);
}

/**
 * Verifies that there is a return tag in comment if a return statement exists inside the method.
 */
class Symfony2_Sniffs_Commenting_FunctionCommentSniff extends PEAR_Sniffs_Commenting_FunctionCommentSniff
{
    /**
     * @var string
     */
    public $requiredScopes = 'public';

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if (false === $commentEnd = $phpcsFile->findPrevious(array(T_COMMENT, T_DOC_COMMENT, T_CLASS, T_FUNCTION, T_OPEN_TAG), ($stackPtr - 1))) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $code = $tokens[$commentEnd]['code'];

        $method = $phpcsFile->getMethodProperties($stackPtr);
        $commentRequired = $this->isRequiredScope($method['scope']);

        if (($code === T_COMMENT && !$commentRequired)
            || ($code !== T_DOC_COMMENT && !$commentRequired)
        ) {
            return;
        }

        parent::process($phpcsFile, $stackPtr);
    }

    /**
     * {@inheritdoc}
     */
    protected function processReturn(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $commentStart)
    {
        if ($this->isInheritDoc($phpcsFile, $stackPtr)) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $funcPtr = $phpcsFile->findNext(T_FUNCTION, $commentStart);

        if (isset($tokens[$stackPtr]['scope_opener'])) {
            $start = $tokens[$stackPtr]['scope_opener'];

            while ($returnToken = $phpcsFile->findNext(T_RETURN, $start, $tokens[$stackPtr]['scope_closer'])) {
                if ($this->isMatchingReturn($tokens, $returnToken)) {
                    $this->processReturnCore($phpcsFile, $stackPtr, $commentStart);
                    break;
                }
                $start = $returnToken + 1;
            }
        }
    }

    /**
     * Process the return comment of this function comment.
     *
     * @param PHP_CodeSniffer_File $phpcsFile    The file being scanned.
     * @param int                  $stackPtr     The position of the current token
     *                                           in the stack passed in $tokens.
     * @param int                  $commentStart The position in the stack where the comment started.
     *
     * @return void
     */
    protected function processReturnCore(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $commentStart)
    {
        $tokens = $phpcsFile->getTokens();

        $methodName      = $phpcsFile->getDeclarationName($stackPtr);
        $isSpecialMethod = ($methodName === '__construct' || $methodName === '__destruct');

        $return = null;
        foreach ($tokens[$commentStart]['comment_tags'] as $tag) {
            if ($tokens[$tag]['content'] === '@return') {
                if ($return !== null) {
                    $error = 'Only 1 @return tag is allowed in a function comment';
                    $phpcsFile->addError($error, $tag, 'DuplicateReturn');

                    return;
                }

                $return = $tag;
            }
        }

        if ($isSpecialMethod === true) {
            return;
        }

        if ($return !== null) {
            $content = $tokens[($return + 2)]['content'];
            if (empty($content) === true || $tokens[($return + 2)]['code'] !== T_DOC_COMMENT_STRING) {
                $error = 'Return type missing for @return tag in function comment';
                $phpcsFile->addError($error, $return, 'MissingReturnType');
            }
        } else {
            $methodOpener = $phpcsFile->findNext([T_OPEN_CURLY_BRACKET], $tokens[$commentStart]['comment_closer']);
            $methodClosener = $phpcsFile->findEndOfStatement($methodOpener);

            if ($this->checkClosureFunctions($methodOpener, $methodClosener, $phpcsFile, $tokens) === true) {
                return;
            }

            $error = 'Missing @return tag in function comment';
            $phpcsFile->addError($error, $tokens[$commentStart]['comment_closer'], 'MissingReturn');
        }
    }

    /**
     * Checks if the comment an inheritdoc?
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     *
     * @return bool
     */
    protected function isInheritDoc(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $start = $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stackPtr - 1);
        $end = $phpcsFile->findNext(T_DOC_COMMENT_CLOSE_TAG, $start);

        $content = $phpcsFile->getTokensAsString($start, ($end - $start));

        return preg_match('#{@inheritdoc}#i', $content) === 1;
    }

    /**
     * {@inheritdoc}
     */
    protected function processParams(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $commentStart)
    {
        if ($this->isInheritDoc($phpcsFile, $stackPtr)) {
            return;
        }

        parent::processParams($phpcsFile, $stackPtr, $commentStart);
    }

    /**
     * Is the return statement matching?
     *
     * @param array $tokens    Array of tokens
     * @param int   $returnPos Stack position of the T_RETURN token to process
     *
     * @return boolean True if the return does not return anything
     */
    protected function isMatchingReturn($tokens, $returnPos)
    {
        do {
            $returnPos++;
        } while ($tokens[$returnPos]['code'] === T_WHITESPACE);

        return $tokens[$returnPos]['code'] !== T_SEMICOLON;
    }

    /**
     * Check if the given function visibility scope needs to have a docblock.
     *
     * @param string $scope Visibility scope of the function.
     *
     * @return bool
     */
    protected function isRequiredScope($scope)
    {
        return strpos($this->requiredScopes, $scope) !== FALSE;
    }

    /**
     * @param int                   $start
     * @param int                   $end
     * @param PHP_CodeSniffer_File  $phpcsFile
     * @param array                 $tokens
     *
     * @return bool
     */
    private function checkClosureFunctions($start, $end, PHP_CodeSniffer_File $phpcsFile, $tokens)
    {
        $return = $phpcsFile->findNext([T_RETURN], $start, $end);
        $function = $phpcsFile->findPrevious([T_CLOSURE], $return, $start);

        if ($return === false) {
            return null;
        }

        if ($function === false && $return != false) {
            return false;
        }

        if ($phpcsFile->findNext([T_RETURN], $function, $tokens[$function]['scope_closer']) !== false) {
            $nextClosure = self::checkClosureFunctions($return+1, $end, $phpcsFile, $tokens);
            if ($nextClosure === null || $nextClosure === true) {
                return true;
            }
        }

        return false;
    }
}
