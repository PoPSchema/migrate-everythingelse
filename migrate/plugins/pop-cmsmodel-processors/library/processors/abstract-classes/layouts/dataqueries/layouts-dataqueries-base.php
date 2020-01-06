<?php

use PoP\ComponentModel\Modules\ModuleUtils;

abstract class PoP_Module_Processor_LayoutsDataQueriesBase extends PoP_Module_Processor_MultiplesBase
{
    protected function getLayoutSubmodules(array $module)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $layouts = isset($vars['layouts']) ? $vars['layouts'] : array();

        // Convert from moduleFullName back to module
        return array_map(
            [ModuleUtils::class, 'getModuleFromOutputName'],
            $layouts
        );
    }

    public function getSubmodules(array $module): array
    {
        return array_merge(
            parent::getSubmodules($module),
            $this->getLayoutSubmodules($module)
        );
    }
}
