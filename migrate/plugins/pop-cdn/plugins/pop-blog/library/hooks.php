<?php
use PoP\Hooks\Facades\HooksAPIFacade;

 
class PoP_CDN_Blog_CDNHooks
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

        // Trending Tags: added also dependency on POST and COMMENT (apart from TAG),
        // because a trending tag may not be newly created to become trending, so TAG alone doesn't work
        
        $routes = array();
        if ($thumbprint == POP_CDN_THUMBPRINT_USER) {
            $routes = array_filter(
                array(
                    POP_BLOG_ROUTE_SEARCHCONTENT,
                    POP_BLOG_ROUTE_SEARCHUSERS,
                    POP_BLOG_ROUTE_CONTENT,
                    POP_USERS_ROUTE_USERS,
                    POP_BLOG_ROUTE_COMMENTS,
                )
            );
        } elseif ($thumbprint == POP_CDN_THUMBPRINT_POST) {
            $routes = array_filter(
                array(
                    POP_BLOG_ROUTE_SEARCHCONTENT,
                    POP_BLOG_ROUTE_CONTENT,
                )
            );
        } elseif ($thumbprint == POP_CDN_THUMBPRINT_COMMENT) {
            $routes = array_filter(
                array(
                    POP_BLOG_ROUTE_COMMENTS,
                )
            );
        } elseif ($thumbprint == POP_CDN_THUMBPRINT_TAG) {
            $routes = array_filter(
                array(
                    POP_TAXONOMIES_ROUTE_TAGS,
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
            // For the "comments" tab in a single post:
            // eg: getpop.org/en/posts/some-post-title/?tab=comments
            $routes = array_filter(
                array(
                    POP_BLOG_ROUTE_COMMENTS,
                )
            );
            foreach ($routes as $route) {
                $paramvalues[] = array(
                    GD_URLPARAM_ROUTE,
                    $route
                );
            }

            // Fetch the comments through lazy-load when calling POP_POSTS_ROUTE_LOADERS_POSTS_FIELDS, such as Articles in the Details view
            // eg: https://www.mesym.com/en/loaders/posts/data/?pid[0]=21566&pid[1]=21542&pid[2]=21537&pid[3]=21523&pid[4]=21521&pid[5]=21472&pid[6]=21471&pid[7]=21470&pid[8]=21469&pid[9]=21468&pid[10]=21465&pid[11]=21464&fields[0]=recommendpost-count&fields[1]=recommendpost-count-plus1&fields[2]=comments-count&format=updatedata&target=main&module=settingsdata&output=json&theme=wassup&thememode=sliding&themestyle=swift
            $paramvalues[] = array(
                GD_URLPARAM_FIELDS,
                'comments-count'
            );
        }
        
        return $paramvalues;
    }
}
    
/**
 * Initialize
 */
new PoP_CDN_Blog_CDNHooks();
