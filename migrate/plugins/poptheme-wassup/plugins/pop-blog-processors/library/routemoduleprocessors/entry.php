<?php

use PoP\Routing\RouteNatures;
use PoP\Posts\Routing\RouteNatures as PostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Taxonomies\Routing\RouteNatures as TaxonomyRouteNatures;
use PoP\RESTAPI\DataStructureFormatters\RESTDataStructureFormatter;

class PoPTheme_Wassup_Blog_Module_EntryRouteModuleProcessor extends \PoP\ModuleRouting\AbstractEntryRouteModuleProcessor
{
    // public function getModulesVarsPropertiesByNature()
    // {
    //     $ret = array();

    //     // API
    //     if (!\PoP\API\Environment::disableAPI()) {
    //         // Home
    //         $ret[RouteNatures::HOME][] = [
    //             'module' => [PoP_Blog_Module_Processor_FieldDataloads::class, PoP_Blog_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS],
    //             'conditions' => [
    //                 'scheme' => POP_SCHEME_API,
    //             ],
    //         ];
    //     }

    //     return $ret;
    // }

    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        // API
        if (!\PoP\API\Environment::disableAPI()) {
            
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();

            // Page
            $routemodules = array(
                POP_BLOG_ROUTE_CONTENT => [PoP_Blog_Module_Processor_FieldDataloads::class, PoP_Blog_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS],
            );
            foreach ($routemodules as $route => $module) {
                $ret[RouteNatures::STANDARD][$route][] = [
                    'module' => $module,
                    'conditions' => [
                        'scheme' => POP_SCHEME_API,
                    ],
                ];
            }

            // REST API Page
            $routemodules = array(
                POP_BLOG_ROUTE_CONTENT => [PoP_Blog_Module_Processor_FieldDataloads::class, PoP_Blog_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_CONTENTLIST_FIELDS],
            );
            foreach ($routemodules as $route => $module) {
                $ret[RouteNatures::STANDARD][$route][] = [
                    'module' => $module,
                    'conditions' => [
                        'scheme' => POP_SCHEME_API,
                        'datastructure' => RESTDataStructureFormatter::getName(),
                    ],
                ];
            }

            // Author
            $routemodules = array(
                POP_BLOG_ROUTE_CONTENT => [PoP_Blog_Module_Processor_FieldDataloads::class, PoP_Blog_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_AUTHORCONTENTLIST_FIELDS],
            );
            foreach ($routemodules as $route => $module) {
                $ret[UserRouteNatures::USER][$route][] = [
                    'module' => $module,
                    'conditions' => [
                        'scheme' => POP_SCHEME_API,
                    ],
                ];
            }

            // Tag
            $routemodules = array(
                POP_BLOG_ROUTE_CONTENT => [PoP_Blog_Module_Processor_FieldDataloads::class, PoP_Blog_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_TAGCONTENTLIST_FIELDS],
            );
            foreach ($routemodules as $route => $module) {
                $ret[TaxonomyRouteNatures::TAG][$route][] = [
                    'module' => $module,
                    'conditions' => [
                        'scheme' => POP_SCHEME_API,
                    ],
                ];
            }

            // Single
            $routemodules = array(
                POP_ROUTE_AUTHORS => [PoP_Blog_Module_Processor_FieldDataloads::class, PoP_Blog_Module_Processor_FieldDataloads::MODULE_DATALOAD_DATAQUERY_SINGLEAUTHORLIST_FIELDS],
            );
            foreach ($routemodules as $route => $module) {
                $ret[PostRouteNatures::POST][$route][] = [
                    'module' => $module,
                    'conditions' => [
                        'scheme' => POP_SCHEME_API,
                    ],
                ];
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
    new PoPTheme_Wassup_Blog_Module_EntryRouteModuleProcessor()
	);
}, 200);
