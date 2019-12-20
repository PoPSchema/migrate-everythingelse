<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Posts\Facades\PostTypeAPIFacade;

// HooksAPIFacade::getInstance()->addFilter('gdPostParentpageid', 'categorypostsPostParentpageid', 10, 2);
// function categorypostsPostParentpageid($pageid, $post_id)
// {
//     $postTypeAPI = PostTypeAPIFacade::getInstance();
//     if ($postTypeAPI->getPostType($post_id) == 'post') {
//         $cats = PoP_CategoryPosts_Utils::getCats();
//         $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
//         $post_cats = $taxonomyapi->getPostCategories($post_id, ['return-type' => POP_RETURNTYPE_IDS]);
//         if ($intersected = array_values(array_intersect($cats, $post_cats))) {
//             $cat_routes = PoP_CategoryPosts_Utils::getCatRoutes();
//             return $cat_routes[$intersected[0]];
//         }
//     }

//     return $pageid;
// }
