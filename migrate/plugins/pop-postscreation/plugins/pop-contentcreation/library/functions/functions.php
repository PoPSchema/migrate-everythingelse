<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Engine\Route\RouteUtils;

/**
 * createupdate-utils.php
 */
HooksAPIFacade::getInstance()->addFilter('gd-createupdateutils:edit-url', 'popPostscreationCreateupdateutilsEditUrl', 0, 2);
function popPostscreationCreateupdateutilsEditUrl($url, $post_id)
{
    $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
    if ($cmspostsapi->getPostType($post_id) == 'post') {
        return RouteUtils::getRouteURL(POP_POSTSCREATION_ROUTE_EDITPOST);
    }

    return $url;
}
