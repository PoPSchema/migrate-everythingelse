<?php
use PoP\Hooks\Facades\HooksAPIFacade;

define('GD_URE_ROLE_COMMUNITY', 'community');

HooksAPIFacade::getInstance()->addFilter('gdRoles', 'gdUreAddCommunityRole');
function gdUreAddCommunityRole($roles)
{
    $roles[] = GD_URE_ROLE_COMMUNITY;
    return $roles;
}

HooksAPIFacade::getInstance()->addFilter('getUserRoleCombinations', 'getUserRoleCombinationsCommunityRole');
function getUserRoleCombinationsCommunityRole($user_role_combinations)
{

    // 2 Combinations: a user may be a community or not
    $user_role_combinations = array(
        array(
            GD_ROLE_PROFILE,
        ),
        array(
            GD_ROLE_PROFILE,
            GD_URE_ROLE_COMMUNITY,
        ),
    );
    return $user_role_combinations;
}

function gdUreIsCommunity($user = null)
{
    return isProfile($user) && \PoP\UserRoles\Utils::hasRole(GD_URE_ROLE_COMMUNITY, $user);
}

function gdUreGetuserrole($user_id)
{
    if (isProfile($user_id)) {
        $role = GD_ROLE_PROFILE;
    } else {
        $cmsuserrolesapi = \PoP\UserRoles\FunctionAPIFactory::getInstance();
        $roles = $cmsuserrolesapi->getUserRoles($user_id);
        $role = $roles[0];
    }

    // Allow to return Organization/Individual roles
    return HooksAPIFacade::getInstance()->applyFilters(
        'gdUreGetuserrole',
        $role,
        $user_id
    );
}



// Make sure we always get the most specific role
HooksAPIFacade::getInstance()->addFilter('UserTypeResolver:getValue:role', 'gdUreGetuserroleHook', 10, 2);
function gdUreGetuserroleHook($role, $user_id)
{
    return gdUreGetuserrole($user_id);
}

// Override the generic function with this one
HooksAPIFacade::getInstance()->addFilter('getTheUserRole', 'gdUreGetTheUserRole', 10, 2);
function gdUreGetTheUserRole($role, $user_id)
{
    return gdUreGetuserrole($user_id);
}
