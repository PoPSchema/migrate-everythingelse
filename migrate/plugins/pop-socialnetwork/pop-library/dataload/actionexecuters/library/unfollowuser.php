<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_UnfollowUser extends GD_FollowUnfollowUser
{
    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();
            $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
            $user_id = $vars['global-userstate']['current-user-id'];
            $target_id = $form_data['target_id'];

            // Check that the logged in user does currently follow that user
            $value = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_FOLLOWSUSERS);
            if (!in_array($target_id, $value)) {
                $errors[] = sprintf(
                    TranslationAPIFacade::getInstance()->__('You were not following <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
                    $cmsusersapi->getUserDisplayName($target_id)
                );
            }
        }
    }

    /**
     * Function to override
     */
    protected function additionals($target_id, $form_data)
    {
        parent::additionals($target_id, $form_data);
        HooksAPIFacade::getInstance()->doAction('gd_unfollowuser', $target_id, $form_data);
    }

    // protected function updateValue($value, $form_data) {

    //     // Remove the user from the list
    //     $target_id = $form_data['target_id'];
    //     array_splice($value, array_search($target_id, $value), 1);
    // }
    protected function update($form_data)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $target_id = $form_data['target_id'];

        // Update values
        \PoP\UserMeta\Utils::deleteUserMeta($user_id, GD_METAKEY_PROFILE_FOLLOWSUSERS, $target_id);
        \PoP\UserMeta\Utils::deleteUserMeta($target_id, GD_METAKEY_PROFILE_FOLLOWEDBY, $user_id);

        // Update the counter
        $count = \PoP\UserMeta\Utils::getUserMeta($target_id, GD_METAKEY_PROFILE_FOLLOWERSCOUNT, true);
        $count = $count ? $count : 0;
        \PoP\UserMeta\Utils::updateUserMeta($target_id, GD_METAKEY_PROFILE_FOLLOWERSCOUNT, ($count - 1), true);

        return parent::update($form_data);
    }
}

