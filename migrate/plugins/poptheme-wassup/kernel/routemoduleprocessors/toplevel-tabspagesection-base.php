<?php

abstract class PoP_Module_TabsPageSectionTopLevelRouteModuleProcessorBase extends \PoP\ModuleRouting\AbstractRouteModuleProcessor
{
    public function getGroups()
    {
        return array(POP_PAGEMODULEGROUP_TOPLEVEL_TABSPAGESECTION);
    }
}
