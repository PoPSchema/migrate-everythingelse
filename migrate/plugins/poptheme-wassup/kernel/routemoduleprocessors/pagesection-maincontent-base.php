<?php

abstract class PoP_Module_MainPageSectionRouteModuleProcessorBase extends \PoP\ModuleRouting\AbstractRouteModuleProcessor
{
    public function getGroups()
    {
        return array(POP_PAGEMODULEGROUP_PAGESECTION_MAINCONTENT);
    }
}
