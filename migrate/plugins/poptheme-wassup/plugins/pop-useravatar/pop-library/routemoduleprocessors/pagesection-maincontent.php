<?php

use PoP\Routing\RouteNatures;

class PoPTheme_Wassup_UserAvatar_Module_MainPageSectionRouteModuleProcessor extends PoP_Module_MainPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $routemodules = array(
            POP_USERAVATAR_ROUTE_EDITAVATAR => [PoP_UserAvatarProcessors_Module_Processor_UserBlocks::class, PoP_UserAvatarProcessors_Module_Processor_UserBlocks::MODULE_BLOCK_USERAVATAR_UPDATE],
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
		new PoPTheme_Wassup_UserAvatar_Module_MainPageSectionRouteModuleProcessor()
	);
}, 200);
