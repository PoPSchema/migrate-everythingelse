<?php
use PoP\Hooks\Facades\HooksAPIFacade;

define('GD_DATALOAD_USER_ROLES', 'roles');

class PoP_UserCommunities_UserStance_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_UserLogin_DataLoad_QueryInputOutputHandler_Hooks:user-feedback',
            array($this, 'getUserFeedback')
        );
    }

    public function getUserFeedback($user_feedback)
    {
        $user_roles = array();
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        if ($vars['global-userstate']['is-user-logged-in']) {
            $user_id = $vars['global-userstate']['current-user-id'];

            // array_values so that it discards the indexes: if will transform an array into an object
            $cmsuserrolesapi = \PoP\UserRoles\FunctionAPIFactory::getInstance();
            $user_roles = array_values(
                array_values(
                    array_intersect(
                        gdRoles(),
                        $cmsuserrolesapi->getUserRoles($user_id)
                    )
                )
            );
        }
        
        $user_feedback[GD_DATALOAD_USER_ROLES] = $user_roles;
        return $user_feedback;
    }
}

/**
 * Initialization
 */
new PoP_UserCommunities_UserStance_Hooks();
