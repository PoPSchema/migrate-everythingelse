<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoPTheme_Wassup_SocialNetwork_WebPlatform_PreloadHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'wassup:extra-routes:initialframes:'.POP_TARGET_ADDONS,
            array($this, 'getRoutesForAddons')
        );
    }

    public function getRoutesForAddons($routes)
    {
        $routes[] = POP_SOCIALNETWORK_ROUTE_CONTACTUSER;
        return $routes;
    }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_SocialNetwork_WebPlatform_PreloadHooks();
