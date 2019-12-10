<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('pop_modulemanager:multilayout_labels', 'gdEmCustomMultilayoutLabels');
function gdEmCustomMultilayoutLabels($labels)
{
    $pluginapi = PoP_Events_APIFactory::getInstance();
    $event_post_type = $pluginapi->getEventPostType();
    $label = '<span class="label label-%s">%s</span>';
    return array_merge(
        array(
            $event_post_type.'-'.POP_EVENTS_SCOPE_FUTURE => sprintf(
                $label,
                'future-events',
                getRouteIcon(POP_EVENTS_ROUTE_EVENTS, true).TranslationAPIFacade::getInstance()->__('Upcoming Event', 'poptheme-wassup')
            ),
            $event_post_type.'-'.POP_EVENTS_SCOPE_CURRENT => sprintf(
                $label,
                'current-events',
                getRouteIcon(POP_EVENTS_ROUTE_EVENTS, true).TranslationAPIFacade::getInstance()->__('Current Event', 'poptheme-wassup')
            ),
            $event_post_type.'-'.POP_EVENTS_SCOPE_PAST => sprintf(
                $label,
                'past-events',
                getRouteIcon(POP_EVENTS_ROUTE_PASTEVENTS, true).TranslationAPIFacade::getInstance()->__('Past Event', 'poptheme-wassup')
            )
        ),
        $labels
    );
}
