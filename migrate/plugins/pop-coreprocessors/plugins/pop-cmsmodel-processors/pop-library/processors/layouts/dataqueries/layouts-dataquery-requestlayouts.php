<?php

class PoP_Module_Processor_RequestLayouts extends PoP_Module_Processor_RequestLayoutsBase
{
    public const MODULE_LAYOUT_DATAQUERY_REQUESTLAYOUTS = 'layout-dataquery-requestlayouts';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_DATAQUERY_REQUESTLAYOUTS],
        );
    }
}



