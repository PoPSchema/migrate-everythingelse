<?php

class PoP_Module_Processor_DataQuery_UpdateDataLayouts extends PoP_Module_Processor_DataQuery_UpdateDataLayoutsBase
{
    public const MODULE_LAYOUT_DATAQUERY_UPDATEDATA = 'layout-dataquery-updatedata';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_DATAQUERY_UPDATEDATA],
        );
    }
}



