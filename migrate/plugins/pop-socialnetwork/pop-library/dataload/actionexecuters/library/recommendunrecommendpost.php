<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

class GD_RecommendUnrecommendPost extends GD_UpdateUserMetaValue_Post
{
    protected function eligible($post)
    {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        $eligible = in_array($postTypeAPI->getPostType($post), $cmsapplicationpostsapi->getAllcontentPostTypes());
        return HooksAPIFacade::getInstance()->applyFilters('GD_RecommendUnrecommendPost:eligible', $eligible, $post);
    }

    /**
     * Function to override
     */
    protected function additionals($target_id, $form_data)
    {
        parent::additionals($target_id, $form_data);
        HooksAPIFacade::getInstance()->doAction('gd_recommendunrecommend_post', $target_id, $form_data);
    }
}
