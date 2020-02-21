<?php
namespace PoP\UserRoles;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\UserRoles\Facades\UserRoleTypeDataResolverFacade;

class Utils {

    /**
     * Functions to ask if it's a specific type of user
     */
    function hasRole($role, $user_or_user_id)
    {
        if (is_object($user_or_user_id)) {
            $cmsusersresolver = \PoP\Users\ObjectPropertyResolverFactory::getInstance();
            $user = $user_or_user_id;
            $userID = $cmsusersresolver->getUserId($user);
        } else {
            $userID = $user_or_user_id;
        }

        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $roles = $userRoleTypeDataResolver->getUserRoles($userID);
        return in_array($role, $roles);
    }

    function getTheUserRole($userID)
    {
        $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
        $roles = $userRoleTypeDataResolver->getUserRoles($userID);

        // Allow URE to override this function
        return HooksAPIFacade::getInstance()->applyFilters('getTheUserRole', $roles[0], $user_id);
    }
}
