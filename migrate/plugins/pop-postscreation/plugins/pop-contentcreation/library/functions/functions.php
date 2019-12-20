<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Engine\Route\RouteUtils;
use PoP\Posts\Facades\PostTypeAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd-createupdateutils:edit-url', 'popPostscreationCreateupdateutilsEditUrl', 0, 2);
function popPostscreationCreateupdateutilsEditUrl($url, $post_id)
{
    $cmspostsapi = PostTypeAPIFacade::getInstance();
    if ($cmspostsapi->getPostType($post_id) == 'post') {
        return RouteUtils::getRouteURL(POP_POSTSCREATION_ROUTE_EDITPOST);
    }

    return $url;
}
