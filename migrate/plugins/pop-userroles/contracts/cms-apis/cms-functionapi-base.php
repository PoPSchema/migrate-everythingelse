<?php
namespace PoP\UserRoles;

abstract class FunctionAPI_Base implements FunctionAPI
{
    public function __construct()
    {
        FunctionAPIFactory::setInstance($this);
    }

    public function currentUserCan($capability)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        return $this->userCan($vars['global-userstate']['current-user-id'], $capability);
    }
}
