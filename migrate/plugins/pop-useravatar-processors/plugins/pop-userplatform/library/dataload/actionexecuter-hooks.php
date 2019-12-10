<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_UserAvatarProcessors_UserPlatform_ActionExecuter_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addAction(
            'gd_createupdate_user:additionalsCreate',
            array($this, 'additionalsCreate'),
            10,
            2
        );
    }

    public function additionalsCreate($user_id, $form_data)
    {

        // Save the user avatar
        $gd_useravatar_update = GD_UserAvatar_UpdateFactory::getInstance();
        $gd_useravatar_update->savePicture($user_id, true);
    }
}

/**
 * Initialization
 */
new PoP_UserAvatarProcessors_UserPlatform_ActionExecuter_Hooks();
