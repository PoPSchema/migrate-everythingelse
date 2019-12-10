<?php

use PoP\Routing\RouteNatures;
use PoP\Posts\Routing\RouteNatures as PostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Taxonomies\Routing\RouteNatures as TaxonomyRouteNatures;

class PoPTheme_Wassup_Bootstrap_Module_MainPageSectionRouteModuleProcessor extends PoP_Module_MainPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        // Single
        $routemodules = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SingleTabPanelSectionBlocks::class, PoP_Module_Processor_SingleTabPanelSectionBlocks::MODULE_BLOCK_TABPANEL_SINGLEAUTHORS],
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

    public function getModulesVarsPropertiesByNature()
    {
        $ret = array();

        $ret[UserRouteNatures::USER][] = [
            'module' => [PoP_Module_Processor_AuthorTabPanelSectionBlocks::class, PoP_Module_Processor_AuthorTabPanelSectionBlocks::MODULE_BLOCK_TABPANEL_AUTHORCONTENT],
            'conditions' => [
                'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
            ],
        ];
        $ret[TaxonomyRouteNatures::TAG][] = [
            'module' => [PoP_Module_Processor_TagTabPanelSectionBlocks::class, PoP_Module_Processor_TagTabPanelSectionBlocks::MODULE_BLOCK_TABPANEL_TAGCONTENT],
            'conditions' => [
                'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
            ],
        ];
        $ret[RouteNatures::HOME][] = [
            'module' => [PoP_Module_Processor_HomeTabPanelSectionBlocks::class, PoP_Module_Processor_HomeTabPanelSectionBlocks::MODULE_BLOCK_TABPANEL_HOMECONTENT],
            'conditions' => [
                'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
            ],
        ];

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() { 
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoPTheme_Wassup_Bootstrap_Module_MainPageSectionRouteModuleProcessor()
	);
}, 200);
