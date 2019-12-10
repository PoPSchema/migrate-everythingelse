<?php

abstract class PoP_Module_Processor_FieldsDataQueriesBase extends PoPEngine_QueryDataModuleProcessorBase
{
    public function getDataFields(array $module, array &$props): array
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $fields = isset($vars['query']) ? $vars['query'] : array();

        // Only allow from a specific list of fields. Precaution against hackers.
        $dataquery_manager = \PoP\ComponentModel\DataQueryManagerFactory::getInstance();
        return $dataquery_manager->filterAllowedfields($fields);
    }
}
