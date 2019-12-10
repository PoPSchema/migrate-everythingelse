<?php

use PoP\Routing\RouteNatures;

class PoPSystem_Theme_Module_EntryRouteModuleProcessor extends \PoP\ModuleRouting\AbstractEntryRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $routemodules = array(
            POP_SYSTEM_ROUTE_SYSTEM_GENERATETHEME => [PoP_System_Theme_Module_Processor_SystemActions::class, PoP_System_Theme_Module_Processor_SystemActions::MODULE_DATALOADACTION_SYSTEM_GENERATETHEME],
        );
        foreach ($routemodules as $route => $module) {
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
    new PoPSystem_Theme_Module_EntryRouteModuleProcessor()
	);
}, 200);
