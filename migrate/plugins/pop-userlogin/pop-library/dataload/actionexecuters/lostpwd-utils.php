<?php

class GD_LostPasswordUtils
{
    public static function getCode($key, $user_login)
    {
        return $key.'|'.rawurlencode($user_login);
    }

    public static function decodeCode($code)
    {
        list($key, $user_login) = explode('|', stripslashes($code)/*wp_unslash($code)*/, 2);
        $user_login = rawurldecode($user_login);

        return array(
            'key' => $key,
            'login' => $user_login,
        );
    }
}
