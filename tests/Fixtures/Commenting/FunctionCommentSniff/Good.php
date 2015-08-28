<?php

namespace AppBundle\Service;

/**
 * Class UserWriter
 *
 * @package AppBundle\Service
 */
class UserWriter
{
    /**
     * here is no return value because the return is only in the lambda function
     */
    public function doSomething()
    {
        $array = [];

        $filtered_array = array_filter($array, function() {
            return 1;
        });
    }
}
