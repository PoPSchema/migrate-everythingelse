<?php
use PoP\Hooks\Facades\HooksAPIFacade;

 
class PoP_CDN_Taxonomies_CDNHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_CDN_FileReproduction_ThumbprintsConfig:criteriaitems:thumbprint:startsWith:partial',
            array($this, 'getThumbprintPartialpaths'),
            10,
            2
        );
    }

    public function getThumbprintPartialpaths($paths, $thumbprint)
    {

        // Trending Tags: added also dependency on POST and COMMENT (apart from TAG),
        // because a trending tag may not be newly created to become trending, so TAG alone doesn't work
        
        $routes = array();
        if ($thumbprint == POP_CDN_THUMBPRINT_TAG) {
            $routes = array_filter(
                array(
                    POP_TAXONOMIES_ROUTE_LOADERS_TAGS_FIELDS,
                    POP_TAXONOMIES_ROUTE_LOADERS_TAGS_LAYOUTS,
                )
            );
        }

        // Add the values to the configuration
        foreach ($routes as $route) {
            $paths[] = $route.'/';
        }
        
        return $paths;
    }
}
    
/**
 * Initialize
 */
new PoP_CDN_Taxonomies_CDNHooks();
