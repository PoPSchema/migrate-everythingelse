<?php

use PoP\Routing\RouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Taxonomies\Routing\RouteNatures as TaxonomyRouteNatures;

class PoPTheme_Wassup_SP_EM_Bootstrap_Module_MainContentRouteModuleProcessor extends \PoP\Application\AbstractMainContentRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $routemodules = array(
            POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_SectionTabPanelBlocks::class, PoP_LocationPosts_Module_Processor_SectionTabPanelBlocks::MODULE_BLOCK_TABPANEL_LOCATIONPOSTS],
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
            POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_AuthorSectionTabPanelBlocks::class, PoP_LocationPosts_Module_Processor_AuthorSectionTabPanelBlocks::MODULE_BLOCK_TABPANEL_AUTHORLOCATIONPOSTS],
        );
        foreach ($routemodules as $route => $module) {
            $ret[UserRouteNatures::USER][$route][] = [
                'module' => $module,
                'conditions' => [
                    'themestyle' => GD_THEMESTYLE_WASSUP_EXPANSIVE,
                ],
            ];
        }

        $routemodules = array(
            POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS => [PoP_LocationPosts_Module_Processor_TagSectionTabPanelBlocks::class, PoP_LocationPosts_Module_Processor_TagSectionTabPanelBlocks::MODULE_BLOCK_TABPANEL_TAGLOCATIONPOSTS],
        );
        foreach ($routemodules as $route => $module) {
            $ret[TaxonomyRouteNatures::TAG][$route][] = [
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
		new PoPTheme_Wassup_SP_EM_Bootstrap_Module_MainContentRouteModuleProcessor()
	);
}, 200);
