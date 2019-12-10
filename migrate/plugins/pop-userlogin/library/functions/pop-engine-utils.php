<?php

class PoP_UserLogin_Engine_Utils
{
    public static function calculateAndSetVarsUserState(&$vars)
    {
        $vars['global-userstate'] = [];
        // User (non)logged-in state
        $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
        if ($cmsuseraccountapi->isUserLoggedIn()) {
            $vars['global-userstate']['is-user-logged-in'] = true;
            $vars['global-userstate']['current-user'] = $cmsuseraccountapi->getCurrentUser();
            $vars['global-userstate']['current-user-id'] = $cmsuseraccountapi->getCurrentUserId();
        } else {
            $vars['global-userstate']['is-user-logged-in'] = false;
            $vars['global-userstate']['current-user'] = null;
            $vars['global-userstate']['current-user-id'] = null;
        }
    }
}
