<?php

use PoP\Routing\RouteNatures;

class PoPTheme_Wassup_SystemPersistentDefinitions_Module_ContentPageSectionTopLevelRouteModuleProcessor extends PoP_Module_ContentPageSectionTopLevelRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $routes = array(
            POP_SYSTEM_ROUTE_SYSTEM_SAVEDEFINITIONFILE,
        );
        foreach ($routes as $route) {
            $ret[RouteNatures::STANDARD][$route][] = [
                'module' => [PoP_Module_Processor_PageSectionContainers::class, PoP_Module_Processor_PageSectionContainers::MODULE_PAGESECTIONCONTAINER_HOLE],
                'conditions' => [
                    'target' => POP_TARGET_MAIN,
                ],
            ];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() { 
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoPTheme_Wassup_SystemPersistentDefinitions_Module_ContentPageSectionTopLevelRouteModuleProcessor()
	);
}, 200);
