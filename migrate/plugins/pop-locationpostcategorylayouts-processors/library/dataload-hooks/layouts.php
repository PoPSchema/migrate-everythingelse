<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\LocationPosts\TypeResolvers\LocationPostTypeResolver;

class PoP_LocationPostCategoryLayouts_LayoutDataloadHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_Application:TypeResolver_Posts:multilayout-keys',
            array($this, 'addMultilayoutKeys'),
            10,
            2
        );
    }

    public function addMultilayoutKeys($keys, $post_id)
    {
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        if ($cmspostsapi->getPostType($post_id) == POP_LOCATIONPOSTS_POSTTYPE_LOCATIONPOST) {
            // Add the layout if the post has any of the defined categories for the Map Layout
            $add_layout = false;
            foreach (POP_LOCATIONPOSTCATEGORYLAYOUTS_CATEGORIES_LAYOUTMAP as $cat) {
                if ($add_layout = $taxonomyapi->hasTerm($cat, POP_LOCATIONPOSTS_TAXONOMY_CATEGORY, $post_id)) {
                    break;
                }
            }
            if ($add_layout) {
                // Priority: place it before the 'post-type' layout key
                array_unshift($keys, LocationPostTypeResolver::NAME.'-map');
            }
        }
        return $keys;
    }
}

/**
 * Initialize
 */
new PoP_LocationPostCategoryLayouts_LayoutDataloadHooks();
