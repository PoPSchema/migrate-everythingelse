<?php

use PoP\Routing\RouteNatures;

class PoP_Application_ClusterCommonPages_Module_MainContentRouteModuleProcessor extends \PoP\Application\AbstractMainContentRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $modules = array(
            POP_CLUSTERCOMMONPAGES_ROUTE_ABOUT_OURSPONSORS => [GD_ClusterCommonPages_Module_Processor_CustomGroups::class, GD_ClusterCommonPages_Module_Processor_CustomGroups::MODULE_GROUP_OURSPONSORS],
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
		new PoP_Application_ClusterCommonPages_Module_MainContentRouteModuleProcessor()
	);
}, 200);
