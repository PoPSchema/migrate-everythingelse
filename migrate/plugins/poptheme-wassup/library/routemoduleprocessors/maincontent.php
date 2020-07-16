<?php

use PoP\Routing\RouteNatures;
use PoP\Pages\Routing\RouteNatures as PageRouteNatures;
use PoP\CustomPosts\Routing\RouteNatures as CustomPostRouteNatures;
use PoP\Users\Routing\RouteNatures as UserRouteNatures;
use PoP\Tags\Routing\RouteNatures as TagRouteNatures;

class PoP_Module_MainContentRouteModuleProcessor extends \PoP\Application\AbstractMainContentRouteModuleProcessor
{
    public function getModulesVarsPropertiesByNatureAndRoute()
    {
        $ret = array();

        // Author
        $modules = array(
            POP_ROUTE_DESCRIPTION => [PoP_Module_Processor_CustomContentBlocks::class, PoP_Module_Processor_CustomContentBlocks::MODULE_BLOCK_AUTHOR_CONTENT],
        );
        foreach ($modules as $route => $module) {
            $ret[UserRouteNatures::USER][$route][] = ['module' => $module];
        }
        // Tag
        $modules = array(
            POP_ROUTE_DESCRIPTION => [PoP_Module_Processor_CustomContentBlocks::class, PoP_Module_Processor_CustomContentBlocks::MODULE_BLOCK_TAG_CONTENT],
        );
        foreach ($modules as $route => $module) {
            $ret[TagRouteNatures::TAG][$route][] = ['module' => $module];
        }

        // Single main content
        $default_format_singleusers = PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_SINGLEUSERS);
        $routemodules_userdetails = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SectionBlocks::class, PoP_Module_Processor_SectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLL_DETAILS],
        );
        foreach ($routemodules_userdetails as $route => $module) {
            $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_DETAILS,
                ],
            ];
            if ($default_format_singleusers == POP_FORMAT_DETAILS) {
                $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = ['module' => $module];
            }
        }
        $routemodules_userfullview = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SectionBlocks::class, PoP_Module_Processor_SectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLL_FULLVIEW],
        );
        foreach ($routemodules_userfullview as $route => $module) {
            $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_FULLVIEW,
                ],
            ];
            if ($default_format_singleusers == POP_FORMAT_FULLVIEW) {
                $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = ['module' => $module];
            }
        }
        $routemodules_userthumbnail = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SectionBlocks::class, PoP_Module_Processor_SectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLL_THUMBNAIL],
        );
        foreach ($routemodules_userthumbnail as $route => $module) {
            $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_THUMBNAIL,
                ],
            ];
            if ($default_format_singleusers == POP_FORMAT_THUMBNAIL) {
                $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = ['module' => $module];
            }
        }
        $routemodules_userlist = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SectionBlocks::class, PoP_Module_Processor_SectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLL_LIST],
        );
        foreach ($routemodules_userlist as $route => $module) {
            $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = [
                'module' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_LIST,
                ],
            ];
            if ($default_format_singleusers == POP_FORMAT_LIST) {
                $ret[CustomPostRouteNatures::CUSTOMPOST][$route][] = ['module' => $module];
            }
        }

        return $ret;
    }

    public function getModulesVarsPropertiesByNature()
    {
        $ret = array();

        // 404
        $ret[RouteNatures::NOTFOUND][] = [
            'module' => [PoP_Module_Processor_Codes::class, PoP_Module_Processor_Codes::MODULE_CODE_404]
        ];

        // Single
        $ret[CustomPostRouteNatures::CUSTOMPOST][] = [
            'module' => [PoP_Module_Processor_CustomContentBlocks::class, PoP_Module_Processor_CustomContentBlocks::MODULE_BLOCK_SINGLE_CONTENT]
        ];

        // Page
        $ret[PageRouteNatures::PAGE][] = [
            'module' => [PoP_Module_Processor_CustomContentBlocks::class, PoP_Module_Processor_CustomContentBlocks::MODULE_BLOCK_PAGE_CONTENT]
        ];

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ModuleRouting\Facades\RouteModuleProcessorManagerFacade::getInstance()->add(
		new PoP_Module_MainContentRouteModuleProcessor()
	);
}, 200);
