<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Routing\DefinitionGroups;
use PoP\Definitions\Facades\DefinitionManagerFacade;
$definitionManager = DefinitionManagerFacade::getInstance();

// Routes
//--------------------------------------------------------
if (!defined('POP_COMMONPAGES_ROUTE_ABOUT')) {
    define('POP_COMMONPAGES_ROUTE_ABOUT', $definitionManager->getUniqueDefinition('about', DefinitionGroups::ROUTES));
}
if (!defined('POP_COMMONPAGES_ROUTE_ABOUT_WHOWEARE')) {
    define('POP_COMMONPAGES_ROUTE_ABOUT_WHOWEARE', $definitionManager->getUniqueDefinition('who-we-are', DefinitionGroups::ROUTES));
}

HooksAPIFacade::getInstance()->addFilter(
    'routes',
    function($routes) {
    	return array_merge(
    		$routes,
    		[
				POP_COMMONPAGES_ROUTE_ABOUT,
				POP_COMMONPAGES_ROUTE_ABOUT_WHOWEARE,
    		]
    	);
    }
);