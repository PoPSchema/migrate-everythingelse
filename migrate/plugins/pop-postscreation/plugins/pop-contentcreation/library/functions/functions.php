<?php
use PoP\Engine\Route\RouteUtils;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\CustomPosts\Facades\CustomPostTypeAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd-createupdateutils:edit-url', 'popPostscreationCreateupdateutilsEditUrl', 0, 2);
function popPostscreationCreateupdateutilsEditUrl($url, $post_id)
{
    $postTypeAPI = PostTypeAPIFacade::getInstance();
    $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
    if ($customPostTypeAPI->getCustomPostType($post_id) == $postTypeAPI->getPostCustomPostType()) {
        return RouteUtils::getRouteURL(POP_POSTSCREATION_ROUTE_EDITPOST);
    }

    return $url;
}
