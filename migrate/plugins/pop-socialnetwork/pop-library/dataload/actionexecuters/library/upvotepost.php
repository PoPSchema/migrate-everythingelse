<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_UpvotePost extends GD_UpvoteUndoUpvotePost
{
    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();
            $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
            $user_id = $vars['global-userstate']['current-user-id'];
            $target_id = $form_data['target_id'];

            // Check that the logged in user has not already recommended this post
            $value = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_UPVOTESPOSTS);
            if (in_array($target_id, $value)) {
                $errors[] = sprintf(
                    TranslationAPIFacade::getInstance()->__('You have already up-voted <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
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
        HooksAPIFacade::getInstance()->doAction('gd_upvotepost', $target_id, $form_data);
    }

    protected function getOppositeInstance()
    {
        return new GD_UndoDownvotePost();
    }

    protected function update($form_data)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $target_id = $form_data['target_id'];

        // Update value
        \PoP\UserMeta\Utils::addUserMeta($user_id, GD_METAKEY_PROFILE_UPVOTESPOSTS, $target_id);
        \PoP\PostMeta\Utils::addPostMeta($target_id, GD_METAKEY_POST_UPVOTEDBY, $user_id);

        // Update the counter
        $count = \PoP\PostMeta\Utils::getPostMeta($target_id, GD_METAKEY_POST_UPVOTECOUNT, true);
        $count = $count ? $count : 0;
        \PoP\PostMeta\Utils::updatePostMeta($target_id, GD_METAKEY_POST_UPVOTECOUNT, ($count + 1), true);

        // Had the user already executed the opposite (Up-vote => Down-vote, etc), then undo it
        $opposite = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_DOWNVOTESPOSTS);
        if (in_array($target_id, $opposite)) {
            $opposite_instance = $this->getOppositeInstance();
            $opposite_instance->undo($form_data);
        }

        return parent::update($form_data);
    }
}

