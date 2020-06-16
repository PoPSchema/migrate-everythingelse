<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Engine\Route\RouteUtils;
use PoP\CustomPosts\Facades\CustomPostTypeAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd-createupdateutils:edit-url', 'popPostscreationCreateupdateutilsEditUrl', 0, 2);
function popPostscreationCreateupdateutilsEditUrl($url, $post_id)
{
    $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
    if ($customPostTypeAPI->getCustomPostType($post_id) == 'post') {
        return RouteUtils::getRouteURL(POP_POSTSCREATION_ROUTE_EDITPOST);
    }

    return $url;
}
