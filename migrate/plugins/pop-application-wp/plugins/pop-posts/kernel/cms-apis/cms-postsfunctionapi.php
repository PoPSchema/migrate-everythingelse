<?php
namespace PoP\Application\WP;

class ApplicationPostsFunctionAPI extends \PoP\Application\PostsFunctionAPI_Base
{
    public function getAllcontentPostTypes()
    {
        // All searchable post types
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
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
