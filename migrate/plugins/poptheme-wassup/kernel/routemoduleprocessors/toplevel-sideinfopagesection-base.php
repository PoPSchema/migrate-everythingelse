<?php

abstract class PoP_Module_SideInfoPageSectionTopLevelRouteModuleProcessorBase extends \PoP\ModuleRouting\AbstractRouteModuleProcessor
{
    public function getGroups()
    {
        return array(POP_PAGEMODULEGROUP_TOPLEVEL_SIDEINFOPAGESECTION);
    }
}
