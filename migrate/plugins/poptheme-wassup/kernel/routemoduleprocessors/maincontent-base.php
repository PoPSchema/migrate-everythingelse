<?php

abstract class PoP_Module_OnlyMainContentRouteModuleProcessorBase extends \PoP\ModuleRouting\AbstractRouteModuleProcessor
{
    public function getGroups()
    {
        return array(POP_PAGEMODULEGROUP_MAINCONTENT);
    }
}
