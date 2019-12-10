<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Engine\FieldResolvers\OperatorFieldResolver;

class PoP_UserLogin_Engine_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addAction(
            '\PoP\ComponentModel\Engine_Vars:addVars', 
            [$this, 'addVars'], 
            10,
            1
        );
        HooksAPIFacade::getInstance()->addAction(
            OperatorFieldResolver::HOOK_SAFEVARS, 
            [$this, 'setSafeVars'], 
            10,
            1
        );
    }
    public function addVars($vars_in_array)
    {
        // User (non)logged-in state
        $vars = &$vars_in_array[0];
        PoP_UserLogin_Engine_Utils::calculateAndSetVarsUserState($vars);
    }
    public function setSafeVars($vars_in_array)
    {
        // Remove the current user object
        $safeVars = &$vars_in_array[0];
        unset($safeVars['global-userstate']['current-user']);
    }
}

/**
 * Initialization
 */
new PoP_UserLogin_Engine_Hooks();
