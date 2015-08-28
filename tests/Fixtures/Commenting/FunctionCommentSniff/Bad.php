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
     * here should be a return value because the return is in the lambda function and in the method
     */
    public function doSomething()
    {
        $array = [];

        $filtered_array = array_filter($array, function() {
            return 1;
        });

        return $filtered_array;
    }
}
