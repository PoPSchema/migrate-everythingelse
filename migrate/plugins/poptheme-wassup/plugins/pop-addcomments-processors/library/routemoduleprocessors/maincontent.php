<?php

use PoP\Routing\RouteNatures;

class PoPTheme_Wassup_AddComments_Module_MainContentRouteModuleProcessor extends \PoP\Application\AbstractMainContentRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $routemodules = array(
            POP_ADDCOMMENTS_ROUTE_ADDCOMMENT => [PoP_Module_Processor_CommentsBlocks::class, PoP_Module_Processor_CommentsBlocks::MODULE_BLOCK_ADDCOMMENT],
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
		new PoPTheme_Wassup_AddComments_Module_MainContentRouteModuleProcessor()
	);
}, 200);
