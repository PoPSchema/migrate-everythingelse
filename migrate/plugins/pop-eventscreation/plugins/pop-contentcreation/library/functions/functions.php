<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Engine\Route\RouteUtils;

HooksAPIFacade::getInstance()->addFilter('gd-createupdateutils:edit-url', 'maybeGetEventEditUrl', 10, 2);
function maybeGetEventEditUrl($url, $post_id)
{
    $pluginapi = PoP_Events_APIFactory::getInstance();
    if ($pluginapi->isEvent($post_id)) {
        // Allow PoP Event Links Creation to hook in its value
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        return HooksAPIFacade::getInstance()->applyFilters(
            'get_event_edit_url',
            RouteUtils::getRouteURL(POP_EVENTSCREATION_ROUTE_EDITEVENT),
            $post_id
        );
    }

    return $url;
}
