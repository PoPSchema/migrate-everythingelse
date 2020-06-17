<?php

use PoP\Routing\RouteNatures;
use PoP\CustomPosts\Routing\RouteNatures as PostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Taxonomies\Routing\RouteNatures as TaxonomyRouteNatures;
use PoP\Events\Facades\EventTypeAPIFacade;

class PoPTheme_Wassup_Events_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $modules = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHOREVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHORPASTEVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_AUTHOREVENTSCALENDAR_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[UserRouteNatures::USER][$route][] = ['module' => $module];
        }

        $modules = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_EVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_PASTEVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_TAG_EVENTS_CALENDAR_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[TaxonomyRouteNatures::TAG][$route][] = ['module' => $module];
        }

        $eventTypeAPI = EventTypeAPIFacade::getInstance();

        // Past single event
        $modules = array(
            POP_ROUTE_AUTHORS => [PoP_Events_CoAuthors_Module_Processor_SidebarMultiples::class, PoP_Events_CoAuthors_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_PASTEVENT_POSTAUTHORSSIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[PostRouteNatures::POST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'routing-state' => [
                        'queried-object-post-type' => $eventTypeAPI->getEventPostType(),
                        'queried-object-is-past-event' => true,
                    ],
                ],
            ];
        }

        // Future and current single event
        $modules = array(
            POP_ROUTE_AUTHORS => [PoP_Events_CoAuthors_Module_Processor_SidebarMultiples::class, PoP_Events_CoAuthors_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_EVENT_POSTAUTHORSSIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[PostRouteNatures::POST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'routing-state' => [
                        'queried-object-post-type' => $eventTypeAPI->getEventPostType(),
                    ],
                ],
            ];
        }

        $modules = array(
            POP_EVENTS_ROUTE_EVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_EVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_PASTEVENTS => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_PASTEVENTS_SIDEBAR],
            POP_EVENTS_ROUTE_EVENTSCALENDAR => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SECTION_EVENTS_CALENDAR_SIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = ['module' => $module];
        }

        return $ret;
    }

    public function getModulesVarsPropertiesByNature()
    {
        $ret = array();

        $eventTypeAPI = EventTypeAPIFacade::getInstance();

        // Past single event
        $ret[PostRouteNatures::POST][] = [
            'module' => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_PASTEVENT_SIDEBAR],
            'conditions' => [
                'routing-state' => [
                    'queried-object-post-type' => $eventTypeAPI->getEventPostType(),
                    'queried-object-is-past-event' => true,
                ],
            ],
        ];

        // Future and current single event
        $ret[PostRouteNatures::POST][] = [
            'module' => [GD_EM_Module_Processor_SidebarMultiples::class, GD_EM_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_EVENT_SIDEBAR],
            'conditions' => [
                'routing-state' => [
                    'queried-object-post-type' => $eventTypeAPI->getEventPostType(),
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
		new PoPTheme_Wassup_Events_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
