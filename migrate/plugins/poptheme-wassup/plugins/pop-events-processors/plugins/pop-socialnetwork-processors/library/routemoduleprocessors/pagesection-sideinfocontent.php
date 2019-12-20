<?php

use PoP\Posts\Routing\RouteNatures as PostRouteNatures;
use PoP\Events\FacadesEventTypeAPIFacade;

class PoPTheme_Wassup_Events_SocialNetwork_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $eventTypeAPI = EventTypeAPIFacade::getInstance();

        // Past single event
        $modules = array(
            POP_SOCIALNETWORK_ROUTE_RECOMMENDEDBY => [PoP_Events_SocialNetwork_Module_Processor_SidebarMultiples::class, PoP_Events_SocialNetwork_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_PASTEVENT_RECOMMENDEDBYSIDEBAR],
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
            POP_SOCIALNETWORK_ROUTE_RECOMMENDEDBY => [PoP_Events_SocialNetwork_Module_Processor_SidebarMultiples::class, PoP_Events_SocialNetwork_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_EVENT_RECOMMENDEDBYSIDEBAR],
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

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() { 
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoPTheme_Wassup_Events_SocialNetwork_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
