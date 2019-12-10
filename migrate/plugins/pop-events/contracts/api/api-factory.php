<?php

class PoP_Events_APIFactory
{
    protected static $instance;

    public static function setInstance(PoP_Events_API $instance)
    {
        self::$instance = $instance;
    }

    public static function getInstance(): PoP_Events_API
    {
        return self::$instance;
    }
}
