<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\CustomPosts\Facades\CustomPostTypeAPIFacade;

class PoP_PostCategoryLayouts_LayoutDataloadHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_Application:TypeResolver_Posts:multilayout-keys',
            array($this, 'addMultilayoutKeys'),
            10,
            3
        );
    }

    public function addMultilayoutKeys($keys, $post_id, $typeResolver)
    {
        $categoryapi = \PoP\Categories\FunctionAPIFactory::getInstance();
        if (in_array(POP_POSTCATEGORYLAYOUTS_CATEGORIES_LAYOUTFEATUREIMAGE, $categoryapi->getPostCategories($post_id, ['return-type' => POP_RETURNTYPE_IDS]))) {
            // Priority: place it before the 'postType' layout key
            $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
            array_unshift($keys, strtolower($typeResolver->getTypeName()).'-featureimage');
        }

        return $keys;
    }
}

/**
 * Initialize
 */
new PoP_PostCategoryLayouts_LayoutDataloadHooks();
