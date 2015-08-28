<?php

/**
 * Symfony2_Sniffs_Classes_ClassMethodsOrderSniff.
 *
 * Throws errors if class visibility order is wrong
 *
 */
class Symfony2_Sniffs_Classes_ClassMethodsOrderSniff implements PHP_CodeSniffer_Sniff
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
     * @return void|boolean
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $methods = $this->getMethods($stackPtr, $phpcsFile);
        $result = $this->checkMethodOrder($methods);

        if (false === $result) {
            $phpcsFile->addWarning(
                'Wrong php method visibility order',
                $stackPtr
            );
        }
    }

    /**
     * @param int                  $stackPtr
     * @param PHP_CodeSniffer_File $phpcsFile
     *
     * @return array
     */
    protected function getMethods($stackPtr, $phpcsFile)
    {
        $methods = [];
        $classEnd = $phpcsFile->findEndOfStatement($stackPtr);

        while ($stackPtr < $classEnd) {
            $function = $phpcsFile->findNext([T_FUNCTION], $stackPtr, null);

            if (false === $function) {
                break;
            }

            $stackPtr = $function + 1;

            if(in_array($phpcsFile->getDeclarationName($function), ['setUp', 'tearDown'])) {
                continue;
            }

            $methodProperties = $phpcsFile->getMethodProperties($function);
            $methods[$methodProperties['scope']][] = $function;
        }

        return $methods;
    }

    /**
     * @param array $methods
     *
     * @return bool
     */
    protected function checkMethodOrder($methods)
    {
        if (true !== isset($methods['public'])) {
            $methods['public'][] = 0;
        }

        if (true !== isset($methods['protected'])) {
            $methods['protected'][] = max($methods['public']) + 1;
        }

        if (true !== isset($methods['private'])) {
            $methods['private'][] = max($methods['protected']) + 1;
        }

        if (isset($methods['public'], $methods['protected']) && max($methods['public']) > min($methods['protected'])) {
            return false;
        }

        if (isset($methods['protected'], $methods['private']) && max($methods['protected']) > min($methods['private'])) {
            return false;
        }

        return true;
    }
}