<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

class GD_UpvoteUndoUpvotePost extends GD_UpdateUserMetaValue_Post
{
    protected function eligible($post)
    {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        $eligible = in_array($postTypeAPI->getPostType($post), PoP_SocialNetwork_Utils::getUpdownvotePostTypes());
        return HooksAPIFacade::getInstance()->applyFilters('GD_UpdownvoteUndoUpdownvotePost:eligible', $eligible, $post);
    }

    /**
     * Function to override
     */
    protected function additionals($target_id, $form_data)
    {
        parent::additionals($target_id, $form_data);
        HooksAPIFacade::getInstance()->doAction('gd_upvoteundoupvote_post', $target_id, $form_data);
    }
}
