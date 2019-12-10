<?php

class PoP_UserLogin_Utils
{
    public static function getUserInfo($route = null)
    {
    	if (!$route) {
    		$vars = \PoP\ComponentModel\Engine_Vars::getVars();
	        $route = $vars['route'];
    	}
        return PoP_UserState_Utils::routeRequiresUserState($route);
    }
}
