<?php
use PoP\Hooks\Facades\HooksAPIFacade;

 
class PoPThemeWassup_CDN_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_CDN_FileReproduction_ThumbprintsConfig:criteriaitems:thumbprint:startsWith:partial',
            array($this, 'getThumbprintPartialpaths'),
            10,
            2
        );
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_CDN_FileReproduction_ThumbprintsConfig:criteriaitems:thumbprint:hasParamValues',
            array($this, 'getThumbprintParamvalues'),
            10,
            2
        );
    }

    public function getThumbprintPartialpaths($paths, $thumbprint)
    {
        $routes = array();
        if ($thumbprint == POP_CDN_THUMBPRINT_POST) {
            $routes = array_filter(
                array(
                    POP_ADDHIGHLIGHTS_ROUTE_HIGHLIGHTS,
                    POP_POSTS_ROUTE_POSTS,
                )
            );
        }

        // Add the values to the configuration
        foreach ($routes as $route) {
            $paths[] = $route.'/';
        }
        
        return $paths;
    }

    public function getThumbprintParamvalues($paramvalues, $thumbprint)
    {
        if ($thumbprint == POP_CDN_THUMBPRINT_COMMENT) {
            // Fetch the comments through lazy-load when calling POP_POSTS_ROUTE_LOADERS_POSTS_FIELDS, such as Articles in the feed view
            // eg: https://www.mesym.com/en/loaders/posts/data/?pid[0]=21566&pid[1]=21542&pid[2]=21537&pid[3]=21523&pid[4]=21521&pid[5]=21472&fields[0]=recommendpost-count&fields[1]=recommendpost-count-plus1&fields[2]=userpostactivity-count&format=updatedata&target=main&module=settingsdata&output=json&theme=wassup&thememode=sliding&themestyle=swift
            $paramvalues[] = array(
                GD_URLPARAM_FIELDS,
                'userpostactivity-count'
            );
        }
        
        return $paramvalues;
    }
}
    
/**
 * Initialize
 */
new PoPThemeWassup_CDN_Hooks();
