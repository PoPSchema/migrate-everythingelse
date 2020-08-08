<?php
namespace PoPSchema\UserRoles;

use PoP\ComponentModel\State\ApplicationState;

abstract class FunctionAPI_Base implements FunctionAPI
{
    public function __construct()
    {
        FunctionAPIFactory::setInstance($this);
    }

    public function currentUserCan($capability)
    {
        $vars = ApplicationState::getVars();
        return $this->userCan($vars['global-userstate']['current-user-id'], $capability);
    }
}
