<?php

use PoP\Routing\RouteNatures;

class PoPTheme_Wassup_EngineProcessors_Module_MainContentRouteModuleProcessor extends \PoP\Application\AbstractMainContentRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        $routemodules = array(
            POP_POSTS_ROUTE_LOADERS_POSTS_FIELDS => [PoP_Posts_Module_Processor_PostsDataloads::class, PoP_Posts_Module_Processor_PostsDataloads::MODULE_DATALOAD_DATAQUERY_CONTENT_UPDATEDATA],
            POP_PAGES_ROUTE_LOADERS_PAGES_FIELDS => [PoP_Pages_Module_Processor_PagesDataloads::class, PoP_Pages_Module_Processor_PagesDataloads::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_UPDATEDATA],
            POP_USERS_ROUTE_LOADERS_USERS_FIELDS => [PoP_Users_Module_Processor_UsersDataloads::class, PoP_Users_Module_Processor_UsersDataloads::MODULE_DATALOAD_DATAQUERY_USERS_UPDATEDATA],
            POP_COMMENTS_ROUTE_LOADERS_COMMENTS_FIELDS => [PoP_Comments_Module_Processor_CommentsDataloads::class, PoP_Comments_Module_Processor_CommentsDataloads::MODULE_DATALOAD_DATAQUERY_COMMENTS_UPDATEDATA],
            POP_TAXONOMIES_ROUTE_LOADERS_TAGS_FIELDS => [PoP_Taxonomies_Module_Processor_TaxonomiesDataloads::class, PoP_Taxonomies_Module_Processor_TaxonomiesDataloads::MODULE_DATALOAD_DATAQUERY_TAGS_UPDATEDATA],
            POP_POSTS_ROUTE_LOADERS_POSTS_LAYOUTS => [PoP_Posts_Module_Processor_PostsDataloads::class, PoP_Posts_Module_Processor_PostsDataloads::MODULE_DATALOAD_DATAQUERY_CONTENT_REQUESTLAYOUTS],
            POP_PAGES_ROUTE_LOADERS_PAGES_LAYOUTS => [PoP_Pages_Module_Processor_PagesDataloads::class, PoP_Pages_Module_Processor_PagesDataloads::MODULE_DATALOAD_DATAQUERY_PAGECONTENT_REQUESTLAYOUTS],
            POP_USERS_ROUTE_LOADERS_USERS_LAYOUTS => [PoP_Users_Module_Processor_UsersDataloads::class, PoP_Users_Module_Processor_UsersDataloads::MODULE_DATALOAD_DATAQUERY_USERS_REQUESTLAYOUTS],
            POP_COMMENTS_ROUTE_LOADERS_COMMENTS_LAYOUTS => [PoP_Comments_Module_Processor_CommentsDataloads::class, PoP_Comments_Module_Processor_CommentsDataloads::MODULE_DATALOAD_DATAQUERY_COMMENTS_REQUESTLAYOUTS],
            POP_TAXONOMIES_ROUTE_LOADERS_TAGS_LAYOUTS => [PoP_Taxonomies_Module_Processor_TaxonomiesDataloads::class, PoP_Taxonomies_Module_Processor_TaxonomiesDataloads::MODULE_DATALOAD_DATAQUERY_TAGS_REQUESTLAYOUTS],
        );
        foreach ($routemodules as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = ['module' => $module];
        }

        $routemodules_latestcounts = array(
            POP_POSTS_ROUTE_LOADERS_POSTS_LAYOUTS => [GD_Core_Module_Processor_Blocks::class, GD_Core_Module_Processor_Blocks::MODULE_MULTIPLE_LATESTCOUNTS],
        );
        foreach ($routemodules_latestcounts as $route => $module) {
            $ret[RouteNatures::STANDARD][$route][] = [
                'module' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_LATESTCOUNT,
                ],
            ];
        }
        
        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() { 
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoPTheme_Wassup_EngineProcessors_Module_MainContentRouteModuleProcessor()
	);
}, 200);
