<?php

abstract class PoP_Module_SideContentPageSectionRouteModuleProcessorBase extends \PoP\ModuleRouting\AbstractRouteModuleProcessor
{
    public function getGroups()
    {
        return array(POP_PAGEMODULEGROUP_PAGESECTION_SIDEFRAMECONTENT);
    }
}
