<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoPCore_LayoutHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_Module_Processor_MultipleContentInners:modules:fields',
            array($this, 'getFieldsModule')
        );
        HooksAPIFacade::getInstance()->addFilter(
            'PoP_Module_Processor_MultipleContentInners:modules:layouts',
            array($this, 'getLayoutsModule')
        );
    }

    public function getFieldsModule(?array $module)
    {
        return [PoP_Module_Processor_DataQuery_UpdateDataLayouts::class, PoP_Module_Processor_DataQuery_UpdateDataLayouts::MODULE_LAYOUT_DATAQUERY_UPDATEDATA];
    }
    public function getLayoutsModule(?array $module)
    {
        return [PoP_Module_Processor_RequestLayouts::class, PoP_Module_Processor_RequestLayouts::MODULE_LAYOUT_DATAQUERY_REQUESTLAYOUTS];
    }
}

/**
 * Initialization
 */
new PoPCore_LayoutHooks();
