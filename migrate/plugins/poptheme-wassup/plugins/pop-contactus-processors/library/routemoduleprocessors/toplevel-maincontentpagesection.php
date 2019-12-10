<?php

use PoP\Routing\RouteNatures;

class PoPTheme_Wassup_ContactUs_Module_ContentPageSectionTopLevelRouteModuleProcessor extends PoP_Module_ContentPageSectionTopLevelRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        // The routes below open in the Hover
        $routes = array(
            POP_CONTACTUS_ROUTE_CONTACTUS,
        );
        foreach ($routes as $route) {
            $ret[RouteNatures::STANDARD][$route][] = [
                'module' => [PoP_Module_Processor_Offcanvas::class, PoP_Module_Processor_Offcanvas::MODULE_OFFCANVAS_HOVER],
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
		new PoPTheme_Wassup_ContactUs_Module_ContentPageSectionTopLevelRouteModuleProcessor()
	);
}, 200);
