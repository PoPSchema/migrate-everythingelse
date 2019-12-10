<?php
namespace PoP\UserRoles;
use PoP\Hooks\Facades\HooksAPIFacade;

class Utils {

    /**
     * Functions to ask if it's a specific type of user
     */
    function hasRole($role, $user_or_user_id)
    {
        if (is_object($user_or_user_id)) {
            $cmsusersresolver = \PoP\Users\ObjectPropertyResolverFactory::getInstance();
            $user = $user_or_user_id;
            $user_id = $cmsusersresolver->getUserId($user);
        } else {
            $user_id = $user_or_user_id;
        }
        
        $cmsuserrolesapi = FunctionAPIFactory::getInstance();
        $roles = $cmsuserrolesapi->getUserRoles($user_id);
        return in_array($role, $roles);
    }

    function getTheUserRole($user_id)
    {
        $cmsuserrolesapi = FunctionAPIFactory::getInstance();
        $roles = $cmsuserrolesapi->getUserRoles($user_id);

        // Allow URE to override this function
        return HooksAPIFacade::getInstance()->applyFilters('getTheUserRole', $roles[0], $user_id);
    }
}
