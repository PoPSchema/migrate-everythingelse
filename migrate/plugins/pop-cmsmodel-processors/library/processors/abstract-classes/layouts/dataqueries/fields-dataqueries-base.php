<?php

abstract class PoP_Module_Processor_FieldsDataQueriesBase extends PoPEngine_QueryDataModuleProcessorBase
{
    public function getDataFields(array $module, array &$props): array
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        return isset($vars['query']) ? $vars['query'] : array();
    }
}
