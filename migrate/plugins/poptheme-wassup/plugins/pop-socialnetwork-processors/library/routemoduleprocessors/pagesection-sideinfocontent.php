<?php

use PoP\CustomPosts\Routing\RouteNatures as CustomPostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Tags\Routing\RouteNatures as TaxonomyRouteNatures;

class PoPTheme_Wassup_SocialNetwork_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $modules = array(
            POP_SOCIALNETWORK_ROUTE_RECOMMENDEDBY => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_POST_RECOMMENDEDBYSIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = ['module' => $module];
        }

        $modules = array(
            POP_SOCIALNETWORK_ROUTE_SUBSCRIBERS => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_SUBSCRIBERS_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[TaxonomyRouteNatures::TAG][$route][] = ['module' => $module];
        }

        $modules = array(
            POP_SOCIALNETWORK_ROUTE_FOLLOWERS => [PoP_SocialNetwork_Module_Processor_SidebarMultiples::class, PoP_SocialNetwork_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHORFOLLOWERS_SIDEBAR],
            POP_SOCIALNETWORK_ROUTE_FOLLOWINGUSERS => [PoP_SocialNetwork_Module_Processor_SidebarMultiples::class, PoP_SocialNetwork_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHORFOLLOWINGUSERS_SIDEBAR],
            POP_SOCIALNETWORK_ROUTE_SUBSCRIBEDTO => [PoP_SocialNetwork_Module_Processor_SidebarMultiples::class, PoP_SocialNetwork_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHORSUBSCRIBEDTOTAGS_SIDEBAR],
            POP_SOCIALNETWORK_ROUTE_RECOMMENDEDPOSTS => [PoP_SocialNetwork_Module_Processor_SidebarMultiples::class, PoP_SocialNetwork_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHORRECOMMENDEDPOSTS_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[UserRouteNatures::USER][$route][] = ['module' => $module];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoPTheme_Wassup_SocialNetwork_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
