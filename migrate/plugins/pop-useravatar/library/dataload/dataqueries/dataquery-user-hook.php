<?php

class PoP_UserAvatar_DataQuery_UserHook extends \PoP\Users\DataQuery_UserHookBase
{
    use PoP_UserLogin_DataQuery_Hook_Trait;

    public function getLoggedinuserfields()
    {
        return array(
            'fileupload-picture-url',
        );
    }
}

/**
 * Initialization
 */
new PoP_UserAvatar_DataQuery_UserHook();
