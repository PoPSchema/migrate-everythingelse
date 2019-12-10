<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_UndoUpvotePost extends GD_UpvoteUndoUpvotePost
{
    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();
            $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
            $user_id = $vars['global-userstate']['current-user-id'];
            $target_id = $form_data['target_id'];

            // Check that the logged in user does currently follow that user
            $value = \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_UPVOTESPOSTS);
            if (!in_array($target_id, $value)) {
                $errors[] = sprintf(
                    TranslationAPIFacade::getInstance()->__('You had not up-voted <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
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
        HooksAPIFacade::getInstance()->doAction('gd_undoupvotepost', $target_id, $form_data);
    }

    protected function update($form_data)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $target_id = $form_data['target_id'];

        // Update value
        \PoP\UserMeta\Utils::deleteUserMeta($user_id, GD_METAKEY_PROFILE_UPVOTESPOSTS, $target_id);
        \PoP\PostMeta\Utils::deletePostMeta($target_id, GD_METAKEY_POST_UPVOTEDBY, $user_id);

        // Update the count
        $count = \PoP\PostMeta\Utils::getPostMeta($target_id, GD_METAKEY_POST_UPVOTECOUNT, true);
        $count = $count ? $count : 0;
        \PoP\PostMeta\Utils::updatePostMeta($target_id, GD_METAKEY_POST_UPVOTECOUNT, ($count - 1), true);

        return parent::update($form_data);
    }

    /**
     * Function to be called by the opposite function (Up-vote/Down-vote)
     */
    public function undo($form_data)
    {
        return $this->update($form_data);
    }
}

