<?php

abstract class PoP_Module_BackgroundContentPageSectionRouteModuleProcessorBase extends \PoP\ModuleRouting\AbstractRouteModuleProcessor
{
    public function getGroups()
    {
        return array(POP_PAGEMODULEGROUP_PAGESECTION_BACKGROUNDFRAMECONTENT);
    }
}
