<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

class GD_UnrecommendPost extends GD_RecommendUnrecommendPost
{
    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();
            $cmspostsapi = PostTypeAPIFacade::getInstance();
            $user_id = $vars['global-userstate']['current-user-id'];
            $target_id = $form_data['target_id'];

            // Check that the logged in user does currently follow that user
            $value = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_RECOMMENDSPOSTS);
            if (!in_array($target_id, $value)) {
                $errors[] = sprintf(
                    TranslationAPIFacade::getInstance()->__('You had not recommended <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
                    $cmspostsapi->getTitle($target_id)
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
        HooksAPIFacade::getInstance()->doAction('gd_unrecommendpost', $target_id, $form_data);
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

        // Update value
        \PoP\UserMeta\Utils::deleteUserMeta($user_id, GD_METAKEY_PROFILE_RECOMMENDSPOSTS, $target_id);
        \PoP\PostMeta\Utils::deletePostMeta($target_id, GD_METAKEY_POST_RECOMMENDEDBY, $user_id);

        // Update the count
        $count = \PoP\PostMeta\Utils::getPostMeta($target_id, GD_METAKEY_POST_RECOMMENDCOUNT, true);
        $count = $count ? $count : 0;
        \PoP\PostMeta\Utils::updatePostMeta($target_id, GD_METAKEY_POST_RECOMMENDCOUNT, ($count - 1), true);

        return parent::update($form_data);
    }
}

