<?php

use PoP\Routing\RouteNatures;

class PoPTheme_Wassup_EventsCreation_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $modules = array(
            POP_EVENTSCREATION_ROUTE_MYEVENTS => [PoP_EventsCreation_Module_Processor_SidebarMultiples::class, PoP_EventsCreation_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_MYEVENTS_SIDEBAR],
            POP_EVENTSCREATION_ROUTE_MYPASTEVENTS => [PoP_EventsCreation_Module_Processor_SidebarMultiples::class, PoP_EventsCreation_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_MYPASTEVENTS_SIDEBAR],
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
		new PoPTheme_Wassup_EventsCreation_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
