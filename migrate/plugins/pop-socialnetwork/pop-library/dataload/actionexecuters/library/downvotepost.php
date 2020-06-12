<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\ComponentModel\State\ApplicationState;

class GD_DownvotePost extends GD_DownvoteUndoDownvotePost
{
    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $vars = ApplicationState::getVars();
            $postTypeAPI = PostTypeAPIFacade::getInstance();
            $user_id = $vars['global-userstate']['current-user-id'];
            $target_id = $form_data['target_id'];

            // Check that the logged in user has not already recommended this post
            $value = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_DOWNVOTESPOSTS);
            if (in_array($target_id, $value)) {
                $errors[] = sprintf(
                    TranslationAPIFacade::getInstance()->__('You have already down-voted <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
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
        HooksAPIFacade::getInstance()->doAction('gd_downvotepost', $target_id, $form_data);
    }

    protected function getOppositeInstance()
    {
        return new GD_UndoUpvotePost();
    }

    protected function update($form_data)
    {
        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $target_id = $form_data['target_id'];

        // Update value
        \PoP\UserMeta\Utils::addUserMeta($user_id, GD_METAKEY_PROFILE_DOWNVOTESPOSTS, $target_id);
        \PoP\CustomPostMeta\Utils::addCustomPostMeta($target_id, GD_METAKEY_POST_DOWNVOTEDBY, $user_id);

        // Update the counter
        $count = \PoP\CustomPostMeta\Utils::getCustomPostMeta($target_id, GD_METAKEY_POST_DOWNVOTECOUNT, true);
        $count = $count ? $count : 0;
        \PoP\CustomPostMeta\Utils::updateCustomPostMeta($target_id, GD_METAKEY_POST_DOWNVOTECOUNT, ($count + 1), true);

        // Had the user already executed the opposite (Up-vote => Down-vote, etc), then undo it
        $opposite = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_UPVOTESPOSTS);
        if (in_array($target_id, $opposite)) {
            $opposite_instance = $this->getOppositeInstance();
            $opposite_instance->undo($form_data);
        }

        return parent::update($form_data);
    }
}
