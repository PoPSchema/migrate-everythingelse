<?php

use PoP\CustomPosts\Routing\RouteNatures as PostRouteNatures;

class PoPTheme_Wassup_RelatedPosts_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $modules = array(
            POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_POST_RELATEDCONTENTSIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[PostRouteNatures::POST][$route][] = ['module' => $module];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoPTheme_Wassup_RelatedPosts_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
