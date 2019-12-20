<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

function getTheMainCategories()
{
    return HooksAPIFacade::getInstance()->applyFilters('getTheMainCategories', array());
}

function getTheMainCategory($post_id)
{
    $postTypeAPI = PostTypeAPIFacade::getInstance();
    if ($postTypeAPI->getPostType($post_id) == 'post') {
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        if ($cats = $taxonomyapi->getPostCategories($post_id, ['return-type' => POP_RETURNTYPE_IDS])) {
            // If this post has any of the categories set as main, then return the any one of them
            if ($intersected_cats = array_values(array_intersect($cats, getTheMainCategories()))) {
                return $intersected_cats[0];
            }
        }
    }

    return null;
}

