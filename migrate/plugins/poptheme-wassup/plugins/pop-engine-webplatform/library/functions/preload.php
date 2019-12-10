<?php
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter('\PoP\ComponentModel\Engine:getExtraUris', 'popthemeWassupExtraRoutes');
function popthemeWassupExtraRoutes($extra_routes)
{
    if (!PoPTheme_Wassup_ServerUtils::disablePreloadingPages()) {
        // Load extra URIs for the INITIALFRAMES page
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        if ($vars['routing-state']['is-standard'] && $vars['route'] == POPTHEME_WASSUP_ROUTE_LOADERS_INITIALFRAMES) {
            $target = $vars['target'];
            if ($routes = HooksAPIFacade::getInstance()->applyFilters(
                'wassup:extra-routes:initialframes:'.$target,
                array()
            )) {
                $extra_routes = array_unique(
                    array_merge(
                        $extra_routes,
                        // array_map(array(\PoP\ComponentModel\Utils::class, 'getPageUri'), $routes)
                        $routes
                    )
                );
            }
        }
    }

    return $extra_routes;
}
