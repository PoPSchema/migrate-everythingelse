<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_UpvoteUndoUpvotePost extends GD_UpdateUserMetaValue_Post
{
    protected function eligible($post)
    {
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        $eligible = in_array($cmspostsapi->getPostType($post), PoP_SocialNetwork_Utils::getUpdownvotePostTypes());
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
