<?php
use PoP\LooseContracts\Facades\NameResolverFacade;

function gdCurrentUserCanEdit($post_id = null)
{
    $vars = \PoP\ComponentModel\Engine_Vars::getVars();
    $cmsuserrolesapi = \PoP\UserRoles\FunctionAPIFactory::getInstance();
    $authors = gdGetPostauthors($post_id);
    return $cmsuserrolesapi->currentUserCan(NameResolverFacade::getInstance()->getName('popcms:capability:editPosts')) && (in_array($vars['global-userstate']['current-user-id'], $authors));
}
