<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_FollowUnfollowUser extends GD_UpdateUserMetaValue_User
{

    /**
     * Function to override
     */
    protected function additionals($target_id, $form_data)
    {
        parent::additionals($target_id, $form_data);
        HooksAPIFacade::getInstance()->doAction('gd_followunfollow_user', $target_id, $form_data);
    }
}
