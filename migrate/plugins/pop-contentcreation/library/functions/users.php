<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\LooseContracts\Facades\NameResolverFacade;
use PoPSchema\UserRoles\Facades\UserRoleTypeDataResolverFacade;

function gdCurrentUserCanEdit($post_id = null)
{
    $nameResolver = NameResolverFacade::getInstance();
    $userRoleTypeDataResolver = UserRoleTypeDataResolverFacade::getInstance();
    $vars = ApplicationState::getVars();
    $userID = $vars['global-userstate']['current-user-id'];
    $authors = gdGetPostauthors($post_id);
    $editPostCapability = $nameResolver->getName('popcms:capability:editPosts');
    return $userRoleTypeDataResolver->userCan(
        $userID,
        $editPostCapability
    ) && in_array(
        $userID,
        $authors
    );
}
