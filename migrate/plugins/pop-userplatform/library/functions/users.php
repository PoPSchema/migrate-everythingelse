<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\LooseContracts\Facades\NameResolverFacade;

function gdUserAttributes()
{
    return HooksAPIFacade::getInstance()->applyFilters('gdUserAttributes', array());
}

function gdGetUserattributes($user_id)
{
    return HooksAPIFacade::getInstance()->applyFilters('gdGetUserattributes', array(), $user_id);
}

/**
 * Determine the threshold capability to split admin users from website users
 */
function userHasAccess($capability, $user_id = null)
{
    if (is_null($user_id)) {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
    }
    $cmsuserrolesapi = \PoP\UserRoles\FunctionAPIFactory::getInstance();
    return $cmsuserrolesapi->userCan($user_id, $capability);
}

function userHasAdminAccess($user_id = null)
{
    return userHasAccess(NameResolverFacade::getInstance()->getName('popcms:capability:deletePages'), $user_id);
}
