<?php
use PoP\Hooks\Facades\HooksAPIFacade;

const GD_URE_ROLE_INDIVIDUAL = 'individual';
const GD_URE_ROLE_ORGANIZATION = 'organization';

HooksAPIFacade::getInstance()->addFilter('gdRoles', 'gdUreRolesImpl');
function gdUreRolesImpl($roles)
{
    $roles = array_merge(
        $roles,
        array(
            GD_URE_ROLE_ORGANIZATION,
            GD_URE_ROLE_INDIVIDUAL,
        )
    );
    return $roles;
}

HooksAPIFacade::getInstance()->addFilter('getUserRoleCombinations', 'getUserRoleCombinationsCommonroles', 100);
function getUserRoleCombinationsCommonroles($user_role_combinations)
{

    // Each user is either an Individual or an Organization,
    // and each Organization may be a Community or not (set through plugins/...)
    $user_role_combinations = array(
        array(
            GD_ROLE_PROFILE,
            GD_URE_ROLE_INDIVIDUAL,
        ),
        array(
            GD_ROLE_PROFILE,
            GD_URE_ROLE_ORGANIZATION,
        ),
    );
    return $user_role_combinations;
}

HooksAPIFacade::getInstance()->addFilter('gdUreGetuserrole', 'gdUreGetuserroleCommonroles', 10, 2);
function gdUreGetuserroleCommonroles($role, $user_id)
{
    if (gdUreIsOrganization($user_id)) {
        return GD_URE_ROLE_ORGANIZATION;
    } elseif (gdUreIsIndividual($user_id)) {
        return GD_URE_ROLE_INDIVIDUAL;
    }

    return $role;
}

/**
 * Helper Functions
 */

function gdUreIsOrganization($user_id = null)
{
    return isProfile($user_id) && \PoP\UserRoles\Utils::hasRole(GD_URE_ROLE_ORGANIZATION, $user_id);
}

function gdUreIsIndividual($user_id = null)
{
    return isProfile($user_id) && \PoP\UserRoles\Utils::hasRole(GD_URE_ROLE_INDIVIDUAL, $user_id);
}
