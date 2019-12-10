<?php

use PoP\Engine\Modules\Constants;
use PoP\ComponentModel\Modules\ModuleUtils;

abstract class PoP_Module_Processor_LayoutsDataQueriesBase extends PoP_Module_Processor_MultiplesBase
{
    protected function getLayoutSubmodules(array $module)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $layouts = isset($vars['layouts']) ? $vars['layouts'] : array();

        // Convert from moduleFullName back to module
        $layouts = array_map(
            [ModuleUtils::class, 'getModuleFromOutputName'],
            $layouts
        );

        // Only allow from a specific list of fields. Precaution against hackers.
        $dataquery_manager = \PoP\ComponentModel\DataQueryManagerFactory::getInstance();
        return $dataquery_manager->filterAllowedlayouts($layouts);
    }

    public function getSubmodules(array $module): array
    {
        return array_merge(
            parent::getSubmodules($module),
            $this->getLayoutSubmodules($module)
        );
    }
}
