<?php

use PoP\Routing\RouteNatures;
use PoPSchema\Users\Routing\RouteNatures as UserRouteNatures;
use PoPSchema\Tags\Routing\RouteNatures as TagRouteNatures;

class PoPTheme_Wassup_Blog_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    /**
     * @return array<string, array<string, array<array>>>
     */
    public function getModulesVarsPropertiesByNatureAndRoute(): array
    {
        $ret = array();

        $modules = array(
            POP_BLOG_ROUTE_CONTENT => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_CONTENT_SIDEBAR],
            POP_POSTS_ROUTE_POSTS => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_POSTS_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[TagRouteNatures::TAG][$route][] = ['module' => $module];
        }

        $modules = array(
            POP_BLOG_ROUTE_CONTENT => [PoP_Blog_Module_Processor_SidebarMultiples::class, PoP_Blog_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHORCONTENT_SIDEBAR],
            POP_POSTS_ROUTE_POSTS => [PoP_Blog_Module_Processor_SidebarMultiples::class, PoP_Blog_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHORPOSTS_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[UserRouteNatures::USER][$route][] = ['module' => $module];
        }

        $modules = array(
            POP_BLOG_ROUTE_CONTENT => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_CONTENT_SIDEBAR],
            POP_POSTS_ROUTE_POSTS => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_POSTS_SIDEBAR],
            POP_USERS_ROUTE_USERS => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_USERS_SIDEBAR],
            POP_POSTTAGS_ROUTE_POSTTAGS => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_TAGS_SIDEBAR],
            POP_BLOG_ROUTE_SEARCHCONTENT => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_CONTENT_SIDEBAR],
            POP_BLOG_ROUTE_SEARCHUSERS => [PoP_Module_Processor_SidebarMultiples::class, PoP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_USERS_SIDEBAR],
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
		new PoPTheme_Wassup_Blog_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
