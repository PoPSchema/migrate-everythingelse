<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_RelatedPosts_Notifications_ImplementationHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addAction(
            'popcomponent:notifications:init',
            array($this, 'addNotificationHooks')
        );
    }

    public function addNotificationHooks()
    {
        new PoP_RelatedPosts_Notifications_Hook_Posts();
    }
}

/**
 * Initialize
 */
new PoP_RelatedPosts_Notifications_ImplementationHooks();
