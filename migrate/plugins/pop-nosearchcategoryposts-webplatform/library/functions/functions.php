<?php
use PoP\Hooks\Facades\HooksAPIFacade;

// HooksAPIFacade::getInstance()->addFilter('pop_modulemanager:multilayout_labels', 'nosearchcategorypostsMultilayoutLabels');
// function nosearchcategorypostsMultilayoutLabels($labels) {

//     $label = '<span class="label label-%s">%s</span>';

//     $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
//     foreach (PoP_NoSearchCategoryPosts_Utils::getCatRoutes() as $cat => $route) {

//         $category = get_category($cat);
//         $labels['post-'.$cat] = sprintf(
//             $label,
//             $taxonomyapi->getCategorySlug($cat),
//             getRouteIcon($route, true).gdGetCategoryname($cat)
//         );
//     }

//     return $labels;
// }
