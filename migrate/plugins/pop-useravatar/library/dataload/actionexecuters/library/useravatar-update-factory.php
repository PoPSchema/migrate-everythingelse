<?php

class GD_UserAvatar_UpdateFactory
{
    protected static $instance;

    public static function setInstance(GD_UserAvatar_Update $instance)
    {
        self::$instance = $instance;
    }

    public static function getInstance(): GD_UserAvatar_Update
    {
        return self::$instance;
    }
}
