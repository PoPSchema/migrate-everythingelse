<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_RecommendUnrecommendPost extends GD_UpdateUserMetaValue_Post
{
    protected function eligible($post)
    {
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        $cmsapplicationpostsapi = \PoP\Application\PostsFunctionAPIFactory::getInstance();
        $eligible = in_array($cmspostsapi->getPostType($post), $cmsapplicationpostsapi->getAllcontentPostTypes());
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
