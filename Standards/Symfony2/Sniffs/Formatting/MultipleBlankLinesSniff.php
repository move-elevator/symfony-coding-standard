<?php

/**
 * Throws error if two blank lines are in series.
 */
class Symfony2_Sniffs_Formatting_MultipleBlankLinesSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_CLASS);
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
        $className = $phpcsFile->getDeclarationName($stackPtr);
        $violations = $this->getViolations($phpcsFile->getFilename());

        foreach ($phpcsFile->getTokens() as $pointer => $token) {
            if (false === in_array($token['line'], $violations)) {
                continue;
            }

            $phpcsFile->addError(sprintf('Multiple blank lines are found in class "%s".', $className), $pointer);
        }

        return;
    }

    /**
     * @param $filename
     * @return array
     */
    private function getViolations($filename)
    {
        $lines = file($filename);
        $violations = [];

        foreach (array_keys($lines) as $number) {
            $previous = $number - 1;
            $next = $number + 1;

            if (!isset($lines[$previous])) {
                continue;
            }

            if (!isset($lines[$next])) {
                continue;
            }

            if ('' !== trim($lines[$previous]) || '' !== trim($lines[$next]) || '' !== trim($lines[$number])) {
                continue;
            }

            $violations[] = $number;
        }

        return $violations;
    }
}
