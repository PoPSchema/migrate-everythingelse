<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoPTheme_Wassup_EM_ContentHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_Module_Processor_CustomContentBlocks:single-sidebar:top',
            array($this, 'getTopSidebar'),
            10,
            2
        );
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_Module_Processor_CustomContentBlocks:single-sidebar:bottom',
            array($this, 'getBottomSidebar'),
            10,
            2
        );
    }

    public function getTopSidebar($sidebar, $post_id)
    {
        $pluginapi = PoP_Events_APIFactory::getInstance();
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        if ($cmspostsapi->getPostType($post_id) == $pluginapi->getEventPostType()) {
            return $pluginapi->isFutureEvent($post_id) ? 
                [GD_EM_Module_Processor_CustomPostLayoutSidebars::class, GD_EM_Module_Processor_CustomPostLayoutSidebars::MODULE_LAYOUT_POSTSIDEBARCOMPACT_HORIZONTAL_EVENT] : 
                [GD_EM_Module_Processor_CustomPostLayoutSidebars::class, GD_EM_Module_Processor_CustomPostLayoutSidebars::MODULE_LAYOUT_POSTSIDEBARCOMPACT_HORIZONTAL_PASTEVENT];
        }

        return $sidebar;
    }

    public function getBottomSidebar($sidebar, $post_id)
    {
        $pluginapi = PoP_Events_APIFactory::getInstance();
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        if ($cmspostsapi->getPostType($post_id) == $pluginapi->getEventPostType()) {
            return [PoPCore_Module_Processor_Contents::class, PoPCore_Module_Processor_Contents::MODULE_CONTENT_POSTCONCLUSIONSIDEBAR_HORIZONTAL];
        }

        return $sidebar;
    }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_EM_ContentHooks();
