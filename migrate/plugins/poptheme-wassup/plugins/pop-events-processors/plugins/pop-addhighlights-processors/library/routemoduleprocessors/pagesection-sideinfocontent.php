<?php

use PoP\CustomPosts\Routing\RouteNatures as CustomPostRouteNatures;
use PoP\Events\Facades\EventTypeAPIFacade;

class PoPTheme_Wassup_Events_AddHighlights_Module_SideInfoContentPageSectionRouteModuleProcessor extends PoP_Module_SideInfoContentPageSectionRouteModuleProcessorBase
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $eventTypeAPI = EventTypeAPIFacade::getInstance();

        // Past single event
        $modules = array(
            POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS => [PoP_Events_AddHighlights_Module_Processor_SidebarMultiples::class, PoP_Events_AddHighlights_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_PASTEVENT_HIGHLIGHTSSIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = [
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
            POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS => [PoP_Events_AddHighlights_Module_Processor_SidebarMultiples::class, PoP_Events_AddHighlights_Module_Processor_SidebarMultiples::MODULE_MULTIPLE_SINGLE_EVENT_HIGHLIGHTSSIDEBAR],
        );
        foreach ($modules as $route => $module) {
            $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = [
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
		new PoPTheme_Wassup_Events_AddHighlights_Module_SideInfoContentPageSectionRouteModuleProcessor()
	);
}, 200);
