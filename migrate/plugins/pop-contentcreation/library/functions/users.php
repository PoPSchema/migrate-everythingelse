<?php
use PoP\LooseContracts\Facades\NameResolverFacade;
use PoP\ComponentModel\State\ApplicationState;

function gdCurrentUserCanEdit($post_id = null)
{
    $vars = ApplicationState::getVars();
    $cmsuserrolesapi = \PoP\UserRoles\FunctionAPIFactory::getInstance();
    $authors = gdGetPostauthors($post_id);
    return $cmsuserrolesapi->currentUserCan(NameResolverFacade::getInstance()->getName('popcms:capability:editPosts')) && (in_array($vars['global-userstate']['current-user-id'], $authors));
}
