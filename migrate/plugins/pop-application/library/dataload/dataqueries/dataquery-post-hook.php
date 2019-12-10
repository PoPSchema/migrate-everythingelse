<?php

class PoP_Application_DataQuery_PostHook extends \PoP\Posts\DataQuery_PostHookBase
{
    public function getLazyLayouts()
    {
        return array(
            'comments-lazy' => array(
                'default' => [PoP_Module_Processor_CommentsWrappers::class, PoP_Module_Processor_CommentsWrappers::MODULE_WIDGETWRAPPER_POSTCOMMENTS_APPENDTOSCRIPT],
            ),
            'noheadercomments-lazy' => array(
                'default' => [PoP_Module_Processor_SidebarComponentWrappers::class, PoP_Module_Processor_SidebarComponentWrappers::MODULE_LAYOUTWRAPPER_COMMENTS_APPENDTOSCRIPT],
            ),
        );
    }
}

/**
 * Initialization
 */
new PoP_Application_DataQuery_PostHook();
