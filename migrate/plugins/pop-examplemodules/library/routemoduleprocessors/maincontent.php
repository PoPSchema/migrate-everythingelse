<?php
namespace PoP\ExampleModules;
use PoP\Routing\RouteNatures;
use PoP\Pages\Routing\RouteNatures as PageRouteNatures;
use PoP\Posts\Routing\RouteNatures as PostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Taxonomies\Routing\RouteNatures as TaxonomyRouteNatures;

class MainContentRouteModuleProcessor extends \PoP\Application\AbstractMainContentRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNature()
    {
        return array(
            RouteNatures::HOME => [
                [
                    'module' => [ModuleProcessor_Groups::class, ModuleProcessor_Groups::MODULE_EXAMPLE_HOME],
                ],
            ],
            RouteNatures::NOTFOUND => [
                [
                    'module' => [ModuleProcessor_Layouts::class, ModuleProcessor_Layouts::MODULE_EXAMPLE_404],
                ],
            ],
            TaxonomyRouteNatures::TAG => [
                [
                    'module' => [ModuleProcessor_Groups::class, ModuleProcessor_Groups::MODULE_EXAMPLE_TAG],
                ],
            ],
            UserRouteNatures::USER => [
                [
                    'module' => [ModuleProcessor_Groups::class, ModuleProcessor_Groups::MODULE_EXAMPLE_AUTHOR],
                ],
            ],
            PostRouteNatures::POST => [
                [
                    'module' => [ModuleProcessor_Dataloads::class, ModuleProcessor_Dataloads::MODULE_EXAMPLE_SINGLE],
                ],
            ],
            PageRouteNatures::PAGE => [
                [
                    'module' => [ModuleProcessor_Dataloads::class, ModuleProcessor_Dataloads::MODULE_EXAMPLE_PAGE],
                ],
            ],
        );
    }
}

/**
 * Initialization
 */
add_action('init', function() { 
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new MainContentRouteModuleProcessor()
	);
}, 200);
