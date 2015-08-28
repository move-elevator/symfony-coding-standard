<?php

class Bad2
{

    use Foo;

    /**
     * Comment
     */
    public function __construct()
    {
        echo 'Bar';
    }
}