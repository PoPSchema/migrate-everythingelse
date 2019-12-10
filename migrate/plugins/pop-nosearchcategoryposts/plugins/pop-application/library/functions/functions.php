<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd_postname', 'nosearchcategorypostsPostname', 10, 3);
function nosearchcategorypostsPostname($name, $post_id, $format)
{
    $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
    if ($cmspostsapi->getPostType($post_id) == 'post') {
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
    $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
    if ($cmspostsapi->getPostType($post_id) == 'post') {
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
