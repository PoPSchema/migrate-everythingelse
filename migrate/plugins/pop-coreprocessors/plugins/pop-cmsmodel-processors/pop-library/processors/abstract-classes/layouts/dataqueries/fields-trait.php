<?php

trait PoP_Module_Processor_DataQuery_UpdateDataLayouts_Trait
{
    public function getTemplateResource(array $module, array &$props): ?array
    {
        return [PoP_CoreProcessors_TemplateResourceLoaderProcessor::class, PoP_CoreProcessors_TemplateResourceLoaderProcessor::RESOURCE_LAYOUT_DATAQUERY_UPDATEDATA];
    }

    public function getImmutableConfiguration(array $module, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($module, $props);
        
        $ret['fields'] = $this->getDataFields($module, $props);
        
        return $ret;
    }
}
