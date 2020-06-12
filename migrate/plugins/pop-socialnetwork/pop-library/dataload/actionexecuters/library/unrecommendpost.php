<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\ComponentModel\State\ApplicationState;

class GD_UnrecommendPost extends GD_RecommendUnrecommendPost
{
    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $vars = ApplicationState::getVars();
            $postTypeAPI = PostTypeAPIFacade::getInstance();
            $user_id = $vars['global-userstate']['current-user-id'];
            $target_id = $form_data['target_id'];

            // Check that the logged in user does currently follow that user
            $value = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_RECOMMENDSPOSTS);
            if (!in_array($target_id, $value)) {
                $errors[] = sprintf(
                    TranslationAPIFacade::getInstance()->__('You had not recommended <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
                    $postTypeAPI->getTitle($target_id)
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
        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $target_id = $form_data['target_id'];

        // Update value
        \PoP\UserMeta\Utils::deleteUserMeta($user_id, GD_METAKEY_PROFILE_RECOMMENDSPOSTS, $target_id);
        \PoP\CustomPostMeta\Utils::deleteCustomPostMeta($target_id, GD_METAKEY_POST_RECOMMENDEDBY, $user_id);

        // Update the count
        $count = \PoP\CustomPostMeta\Utils::getCustomPostMeta($target_id, GD_METAKEY_POST_RECOMMENDCOUNT, true);
        $count = $count ? $count : 0;
        \PoP\CustomPostMeta\Utils::updateCustomPostMeta($target_id, GD_METAKEY_POST_RECOMMENDCOUNT, ($count - 1), true);

        return parent::update($form_data);
    }
}

