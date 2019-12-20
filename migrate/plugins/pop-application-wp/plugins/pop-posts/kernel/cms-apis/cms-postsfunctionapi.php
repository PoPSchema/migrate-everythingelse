<?php
namespace PoP\Application\WP;
use PoP\Posts\Facades\PostTypeAPIFacade;

class ApplicationPostsFunctionAPI extends \PoP\Application\PostsFunctionAPI_Base
{
    public function getAllcontentPostTypes()
    {
        // All searchable post types
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $args = array(
            'exclude-from-search' => false,
        );
        return array_keys($cmspostsapi->getPostTypes($args));
    }
}

/**
 * Initialize
 */
new ApplicationPostsFunctionAPI();
