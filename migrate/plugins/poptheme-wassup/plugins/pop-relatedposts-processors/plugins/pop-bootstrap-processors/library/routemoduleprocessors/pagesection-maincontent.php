<?php

use PoP\CustomPosts\Routing\RouteNatures as PostRouteNatures;

class PoPTheme_Wassup_RelatedPosts_Bootstrap_Module_MainPageSectionRouteModuleProcessor extends PoP_Module_MainPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        // Single
        $routemodules = array(
            POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT => [PoP_Module_Processor_SingleTabPanelSectionBlocks::class, PoP_Module_Processor_SingleTabPanelSectionBlocks::MODULE_BLOCK_TABPANEL_SINGLERELATEDCONTENT],
        );
        foreach ($routemodules as $route => $module) {
            $ret[PostRouteNatures::POST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
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
		new PoPTheme_Wassup_RelatedPosts_Bootstrap_Module_MainPageSectionRouteModuleProcessor()
	);
}, 200);
