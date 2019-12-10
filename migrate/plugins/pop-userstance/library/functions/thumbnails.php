<?php
use PoP\Hooks\Facades\HooksAPIFacade;

/**
 * Default thumbs
 */
HooksAPIFacade::getInstance()->addFilter('getThumbId:default', 'userstanceThumbDefaulthighlight', 10, 2);
function userstanceThumbDefaulthighlight($thumb_id, $post_id)
{
    if (POP_USERSTANCE_IMAGE_NOFEATUREDIMAGESTANCEPOST) {
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        if ($cmspostsapi->getPostType($post_id) == POP_USERSTANCE_POSTTYPE_USERSTANCE) {
            return POP_USERSTANCE_IMAGE_NOFEATUREDIMAGESTANCEPOST;
        }
    }

    return $thumb_id;
}
