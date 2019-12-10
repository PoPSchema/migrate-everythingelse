<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_CommonAutomatedEmails_EM_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoPTheme_Wassup_AE_Module_Processor_ContentDataloads:singlepost:sidebar',
            array($this, 'getSidebarLayout'),
            10,
            2
        );
    }

    public function getSidebarLayout($layout, $post_id)
    {
        $pluginapi = PoP_Events_APIFactory::getInstance();
        if ($pluginapi->isEvent($post_id)) {
            return [PoPTheme_Wassup_EM_AE_Module_Processor_CustomPostLayoutSidebars::class, PoPTheme_Wassup_EM_AE_Module_Processor_CustomPostLayoutSidebars::MODULE_LAYOUT_AUTOMATEDEMAILS_POSTSIDEBARCOMPACT_HORIZONTAL_EVENT];
        }
        return $layout;
    }
}

/**
 * Initialization
 */
new PoP_CommonAutomatedEmails_EM_Hooks();
