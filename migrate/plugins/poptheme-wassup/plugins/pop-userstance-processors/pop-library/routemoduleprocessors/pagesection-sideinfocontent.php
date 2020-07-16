<?php

use PoP\Routing\RouteNatures;
use PoP\CustomPosts\Routing\RouteNatures as CustomPostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Tags\Routing\RouteNatures as TaxonomyRouteNatures;

class PoPTheme_Wassup_UserStance_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $modules = array(
            POP_USERSTANCE_ROUTE_STANCES => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_STANCES_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_PRO => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_NEUTRAL => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_AGAINST => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_STANCES_STANCE_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[TaxonomyRouteNatures::TAG][$route][] = ['module' => $module];
        }

        $modules = array(
            POP_USERSTANCE_ROUTE_STANCES => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHOR_STANCES_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_PRO => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_NEUTRAL => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_AGAINST => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHOR_STANCES_STANCE_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[UserRouteNatures::USER][$route][] = ['module' => $module];
        }

        $modules = array(
            POP_USERSTANCE_ROUTE_MYSTANCES => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_MYSTANCES_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_PRO => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_AGAINST => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_NEUTRAL => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_PRO_ARTICLE => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_AGAINST_ARTICLE => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_NEUTRAL_ARTICLE => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_STANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_PRO_GENERAL => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_GENERALSTANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_AGAINST_GENERAL => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_GENERALSTANCE_SIDEBAR],
            POP_USERSTANCE_ROUTE_STANCES_NEUTRAL_GENERAL => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_STANCES_GENERALSTANCE_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = ['module' => $module];
        }

        return $ret;
    }

    public function getModulesVarsPropertiesByNature()
    {
        $ret = array();

        $ret[CustomPostRouteNatures::CUSTOMPOST][] = [
            'module' => [PoPVP_Module_Processor_SidebarMultiples::class, PoPVP_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_STANCE_SIDEBAR],
            'conditions' => [
                'routing-state' => [
                    'queried-object-post-type' => POP_USERSTANCE_POSTTYPE_USERSTANCE,
                ],
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
		new PoPTheme_Wassup_UserStance_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
