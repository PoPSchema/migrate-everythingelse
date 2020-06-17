<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;
use PoP\CustomPosts\Facades\CustomPostTypeAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd_postname', 'nosearchcategorypostsPostname', 10, 3);
function nosearchcategorypostsPostname($name, $post_id, $format)
{
    $postTypeAPI = PostTypeAPIFacade::getInstance();
    $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
    if ($customPostTypeAPI->getCustomPostType($post_id) == $postTypeAPI->getPostCustomPostType()) {
        $cats = PoP_NoSearchCategoryPosts_Utils::getCats();
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        $post_cats = $taxonomyapi->getPostCategories($post_id, ['return-type' => POP_RETURNTYPE_IDS]);
        if ($intersected = array_values(array_intersect($cats, $post_cats))) {
            return gdGetCategoryname($intersected[0], $format);
        }
    }

    return $name;
}


HooksAPIFacade::getInstance()->addFilter('gd_posticon', 'nosearchcategorypostsPosticon', 10, 2);
function nosearchcategorypostsPosticon($icon, $post_id)
{
    $postTypeAPI = PostTypeAPIFacade::getInstance();
    $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
    if ($customPostTypeAPI->getCustomPostType($post_id) == $postTypeAPI->getPostCustomPostType()) {
        $cats = PoP_NoSearchCategoryPosts_Utils::getCats();
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        $post_cats = $taxonomyapi->getPostCategories($post_id, ['return-type' => POP_RETURNTYPE_IDS]);
        if ($intersected = array_values(array_intersect($cats, $post_cats))) {
            $cat_routes = PoP_NoSearchCategoryPosts_Utils::getCatRoutes();
            return getRouteIcon($cat_routes[$intersected[0]], false);
        }
    }

    return $icon;
}
