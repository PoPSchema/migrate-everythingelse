<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_SPAResourceLoader_FileReproduction_InitialResourcesConfig extends PoP_SPAResourceLoader_FileReproduction_AddResourcesConfigBase
{
    // public function getRenderer()
    // {
    //     global $pop_sparesourceloader_initialresources_configfile_renderer;
    //     return $pop_sparesourceloader_initialresources_configfile_renderer;
    // }

    protected function matchNature()
    {
        return 'standard';
    }

    protected function matchPaths()
    {
        // This shall provide an array with the following pages:
        // 1. getBackgroundloadRouteConfigurations:
        // POPTHEME_WASSUP_ROUTE_LOADERS_INITIALFRAMES
        // 2. getNonCacheableRoutes:
        // POP_POSTS_ROUTE_LOADERS_POSTS_FIELDS
        // POP_PAGES_ROUTE_LOADERS_PAGES_FIELDS
        // POP_USERS_ROUTE_LOADERS_USERS_FIELDS
        // POP_COMMENTS_ROUTE_LOADERS_COMMENTS_FIELDS
        // POP_TAGS_ROUTE_LOADERS_TAGS_FIELDS
        // 3. getCacheableRoutes:
        // POP_POSTS_ROUTE_LOADERS_POSTS_LAYOUTS
        // POP_PAGES_ROUTE_LOADERS_PAGES_LAYOUTS
        // POP_USERS_ROUTE_LOADERS_USERS_LAYOUTS
        // POP_COMMENTS_ROUTE_LOADERS_COMMENTS_LAYOUTS
        // POP_TAGS_ROUTE_LOADERS_TAGS_LAYOUTS
        $routes = array_keys(PoP_SPA_ConfigurationUtils::getBackgroundloadRouteConfigurations());

        // Added through hooks:
        // 4. Logged-in User data page
        // Allow to hook in page POP_USERLOGIN_ROUTE_LOGGEDINUSERDATA
        $routes = array_filter(
            array_values(
                HooksAPIFacade::getInstance()->applyFilters(
                    'PoP_SPAResourceLoader_FileReproduction_InitialResourcesConfig:routes',
                    $routes
                )
            )
        );

        // Get the paths for all those routes
        $paths = array();
        foreach ($routes as $route) {
            $paths[] = $route.'/';
        }
        return $paths;
    }
}
