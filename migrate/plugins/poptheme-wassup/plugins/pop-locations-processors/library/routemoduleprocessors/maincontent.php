<?php

use PoP\Routing\RouteNatures;
use PoP\Posts\Routing\RouteNatures as PostRouteNatures;

class Wassup_EM_Module_MainContentRouteModuleProcessor extends \PoP\Application\AbstractMainContentRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $routemodules_map = array(
            POP_ROUTE_AUTHORS => [PoP_Locations_CoAuthors_Module_Processor_CustomScrollMapSectionBlocks::class, PoP_Locations_CoAuthors_Module_Processor_CustomScrollMapSectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLLMAP],
        );
        foreach ($routemodules_map as $route => $module) {
            $ret[PostRouteNatures::POST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_MAP,
                ],
            ];
            if ($default_format_singlesection == POP_FORMAT_MAP) {
                $ret[PostRouteNatures::POST][$route][] = ['module' => $module];
            }
        }

        // Page modules
        $routemodules_allothers = array(
            POP_LOCATIONS_ROUTE_LOCATIONSMAP => [PoP_Module_Processor_LocationsMapBlocks::class, PoP_Module_Processor_LocationsMapBlocks::MODULE_BLOCK_LOCATIONSMAP],
            POP_LOCATIONS_ROUTE_LOCATIONS => [PoP_Locations_Module_Processor_CustomSectionBlocks::class, PoP_Locations_Module_Processor_CustomSectionBlocks::MODULE_BLOCK_LOCATIONS_SCROLL],
        );
        foreach ($routemodules_allothers as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = ['module' => $module];
        }

        $default_format_section = PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_SECTION);

        $routemodules_modals = array(
            POP_LOCATIONS_ROUTE_LOCATIONSMAP => [PoP_Module_Processor_LocationsMapBlocks::class, PoP_Module_Processor_LocationsMapBlocks::MODULE_BLOCK_STATICLOCATIONSMAP],
        );
        foreach ($routemodules_modals as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = [
                'module' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_MODALS,
                ],
            ];
            if ($default_format_singlesection == POP_FORMAT_MODALS) {
                $ret[RouteNatures::STANDARD][$route][] = ['module' => $module];
            }
        }

        $routemodules_typeahead = array(
            POP_LOCATIONS_ROUTE_LOCATIONS => [PoP_Locations_Module_Processor_CustomSectionDataloads::class, PoP_Locations_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_LOCATIONS_TYPEAHEAD],
        );
        foreach ($routemodules_typeahead as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = [
                'module' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_TYPEAHEAD,
                ],
            ];
            if ($default_format_singlesection == POP_FORMAT_TYPEAHEAD) {
                $ret[RouteNatures::STANDARD][$route][] = ['module' => $module];
            }
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() { 
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new Wassup_EM_Module_MainContentRouteModuleProcessor()
	);
}, 200);
