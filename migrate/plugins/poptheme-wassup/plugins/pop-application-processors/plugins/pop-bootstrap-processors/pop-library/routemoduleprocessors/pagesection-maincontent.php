<?php

use PoP\Routing\RouteNatures;
use PoP\CustomPosts\Routing\RouteNatures as PostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;

class PoPTheme_Wassup_ApplicationProcessors_Bootstrap_Module_MainPageSectionRouteModuleProcessor extends PoP_Module_MainPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $routemodules = array(
            POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS => [PoP_AddHighlights_Module_Processor_SectionTabPanelBlocks::class, PoP_AddHighlights_Module_Processor_SectionTabPanelBlocks::MODULE_BLOCK_TABPANEL_HIGHLIGHTS],
            POP_ADDHIGHLIGHTS_ROUTE_MYHIGHLIGHTS => [PoP_AddHighlights_Module_Processor_SectionTabPanelBlocks::class, PoP_AddHighlights_Module_Processor_SectionTabPanelBlocks::MODULE_BLOCK_TABPANEL_MYHIGHLIGHTS],
            POP_POSTSCREATION_ROUTE_MYPOSTS => [PoP_Module_Processor_TabPanelSectionBlocks::class, PoP_Module_Processor_TabPanelSectionBlocks::MODULE_BLOCK_TABPANEL_MYPOSTS],
        );
        foreach ($routemodules as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = [
                'module' => $module,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
                ],
            ];
        }

        $routemodules = array(
            POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS => [PoP_AddHighlights_Module_Processor_SingleSectionTabPanelBlocks::class, PoP_AddHighlights_Module_Processor_SingleSectionTabPanelBlocks::MODULE_BLOCK_TABPANEL_SINGLERELATEDHIGHLIGHTCONTENT],
        );
        foreach ($routemodules as $route => $module) {
            $ret[PostRouteNatures::POST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
                ],
            ];
        }

        $routemodules = array(
            POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS => [PoP_AddHighlights_Module_Processor_AuthorSectionTabPanelBlocks::class, PoP_AddHighlights_Module_Processor_AuthorSectionTabPanelBlocks::MODULE_BLOCK_TABPANEL_AUTHORHIGHLIGHTS],
        );
        foreach ($routemodules as $route => $module) {
            $ret[UserRouteNatures::USER][$route][] = [
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
		new PoPTheme_Wassup_ApplicationProcessors_Bootstrap_Module_MainPageSectionRouteModuleProcessor()
	);
}, 200);
