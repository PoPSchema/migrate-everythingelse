<?php

use PoP\Routing\RouteNatures;

class PoPTheme_Wassup_ContentPostLinksCreation_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $modules = array(
            POP_CONTENTPOSTLINKSCREATION_ROUTE_MYCONTENTPOSTLINKS => [PoP_ContentPostLinksCreation_Module_Processor_SidebarMultiples::class, PoP_ContentPostLinksCreation_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_MYCONTENTPOSTLINKS_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = ['module' => $module];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() { 
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoPTheme_Wassup_ContentPostLinksCreation_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
