<?php

namespace AppBundle\Service;

/**
 * Class Good
 *
 * @package AppBundle\Service
 */
class Good
{
    use NiceTrait;

    /**
     * Comment
     */
    public function __construct()
    {
        array(
            'a' => 'test1',
            'd' => 'test2',
            'g' => 'test3'
        );
    }
}
