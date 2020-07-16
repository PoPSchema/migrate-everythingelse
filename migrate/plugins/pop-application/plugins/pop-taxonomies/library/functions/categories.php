<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\CustomPosts\Facades\CustomPostTypeAPIFacade;

function getTheMainCategories()
{
    return HooksAPIFacade::getInstance()->applyFilters('getTheMainCategories', array());
}

function getTheMainCategory($post_id)
{
    $postTypeAPI = PostTypeAPIFacade::getInstance();
    $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
    if ($customPostTypeAPI->getCustomPostType($post_id) == $postTypeAPI->getPostCustomPostType()) {
        $categoryapi = \PoP\Tags\FunctionAPIFactory::getInstance();
        if ($cats = $categoryapi->getPostCategories($post_id, ['return-type' => POP_RETURNTYPE_IDS])) {
            // If this post has any of the categories set as main, then return the any one of them
            if ($intersected_cats = array_values(array_intersect($cats, getTheMainCategories()))) {
                return $intersected_cats[0];
            }
        }
    }

    return null;
}

