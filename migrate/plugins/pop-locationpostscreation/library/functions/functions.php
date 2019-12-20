<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Engine\Route\RouteUtils;
use PoP\Posts\Facades\PostTypeAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd-createupdateutils:edit-url', 'locationpostsCreateupdateutilsEditUrl', 10, 2);
function locationpostsCreateupdateutilsEditUrl($url, $post_id)
{
    if (defined('POP_LOCATIONPOSTSCREATION_ROUTE_EDITLOCATIONPOST') && POP_LOCATIONPOSTSCREATION_ROUTE_EDITLOCATIONPOST) {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        if ($postTypeAPI->getPostType($post_id) == POP_LOCATIONPOSTS_POSTTYPE_LOCATIONPOST) {
            return RouteUtils::getRouteURL(POP_LOCATIONPOSTSCREATION_ROUTE_EDITLOCATIONPOST);
        }
    }

    return $url;
}
