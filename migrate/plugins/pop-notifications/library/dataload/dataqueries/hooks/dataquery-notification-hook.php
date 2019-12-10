<?php

class GD_DataQuery_NotificationHook extends GD_DataQuery_NotificationHookBase
{
    use PoP_UserLogin_DataQuery_Hook_Trait;

    public function getLoggedinuserfields()
    {
        return array(
            'message',
            'status',
            'is-status-read',
            'is-status-not-read',
        );
    }
}

/**
 * Initialization
 */
new GD_DataQuery_NotificationHook();
