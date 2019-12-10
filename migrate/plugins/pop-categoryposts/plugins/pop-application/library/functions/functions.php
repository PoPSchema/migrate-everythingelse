<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('gd_postname', 'blogPostname', 10, 3);
function blogPostname($name, $post_id, $format)
{
    $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
    if ($cmspostsapi->getPostType($post_id) == 'post') {
        $cats = PoP_CategoryPosts_Utils::getCats();
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        $post_cats = $taxonomyapi->getPostCategories($post_id, ['return-type' => POP_RETURNTYPE_IDS]);
        if ($intersected = array_values(array_intersect($cats, $post_cats))) {
            return gdGetCategoryname($intersected[0], $format);
        }
    }

    return $name;
}


HooksAPIFacade::getInstance()->addFilter('gd_posticon', 'blogPosticon', 10, 2);
function blogPosticon($icon, $post_id)
{
    $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
    if ($cmspostsapi->getPostType($post_id) == 'post') {
        $cats = PoP_CategoryPosts_Utils::getCats();
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        $post_cats = $taxonomyapi->getPostCategories($post_id, ['return-type' => POP_RETURNTYPE_IDS]);
        if ($intersected = array_values(array_intersect($cats, $post_cats))) {
            $cat_routes = PoP_CategoryPosts_Utils::getCatRoutes();
            return getRouteIcon($cat_routes[$intersected[0]], false);
        }
    }

    return $icon;
}
