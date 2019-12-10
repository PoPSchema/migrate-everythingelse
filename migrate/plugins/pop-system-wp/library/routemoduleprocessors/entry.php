<?php

use PoP\Routing\RouteNatures;

class PoPSystem_WP_Module_EntryRouteModuleProcessor extends \PoP\ModuleRouting\AbstractEntryRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $routemodules = array(
            POP_SYSTEMWP_ROUTE_SYSTEM_ACTIVATEPLUGINS => [PoP_SystemWP_WP_Module_Processor_SystemActions::class, PoP_SystemWP_WP_Module_Processor_SystemActions::MODULE_DATALOADACTION_SYSTEM_ACTIVATEPLUGINS],
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
    new PoPSystem_WP_Module_EntryRouteModuleProcessor()
	);
}, 200);
