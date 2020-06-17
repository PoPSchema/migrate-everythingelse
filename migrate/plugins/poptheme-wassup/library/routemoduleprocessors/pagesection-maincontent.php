<?php

use PoP\Routing\RouteNatures;
use PoP\CustomPosts\Routing\RouteNatures as PostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Taxonomies\Routing\RouteNatures as TaxonomyRouteNatures;

class PoP_Module_MainPageSectionRouteModuleProcessor extends PoP_Module_MainPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        // Author
        $modules = array(
            POP_ROUTE_DESCRIPTION => [PoP_Module_Processor_MainBlocks::class, PoP_Module_Processor_MainBlocks::MODULE_BLOCK_AUTHORDESCRIPTION],
            POPTHEME_WASSUP_ROUTE_SUMMARY => [PoP_Module_Processor_MainBlocks::class, PoP_Module_Processor_MainBlocks::MODULE_BLOCK_AUTHORSUMMARY],
        );
        foreach ($modules as $route => $module) {
            $ret[UserRouteNatures::USER][$route][] = ['module' => $module];
        }

        // Override default module
        $routes = array(
            POPTHEME_WASSUP_ROUTE_LOADERS_INITIALFRAMES,
        );
        foreach ($routes as $route) {
            // Override the default Page Content module
            $ret[RouteNatures::STANDARD][$route][] = ['module' => null];
        }

        return $ret;
    }

    public function getModulesVarsPropertiesByNature()
    {
        $ret = array();

        // 404
        $ret[RouteNatures::NOTFOUND][] = [
            'module' => [PoP_Module_Processor_MainBlocks::class, PoP_Module_Processor_MainBlocks::MODULE_BLOCK_404]
        ];

        // Home
        $ret[RouteNatures::HOME][] = [
            'module' => [PoP_Module_Processor_MainBlocks::class, PoP_Module_Processor_MainBlocks::MODULE_BLOCK_HOME]
        ];

        // Author
        $ret[UserRouteNatures::USER][] = [
            'module' => [PoP_Module_Processor_MainBlocks::class, PoP_Module_Processor_MainBlocks::MODULE_BLOCK_AUTHOR]
        ];

        // Tag
        $ret[TaxonomyRouteNatures::TAG][] = [
            'module' => [PoP_Module_Processor_MainBlocks::class, PoP_Module_Processor_MainBlocks::MODULE_BLOCK_TAG]
        ];

        // Single
        $ret[PostRouteNatures::POST][] = [
            'module' => [PoP_Module_Processor_MainBlocks::class, PoP_Module_Processor_MainBlocks::MODULE_BLOCK_SINGLEPOST]
        ];

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoP_Module_MainPageSectionRouteModuleProcessor()
	);
}, 200);
