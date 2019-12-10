<?php
use PoP\Posts\TypeDataResolvers\ConvertiblePostTypeDataResolver;

abstract class PoP_Module_Processor_PostTriggerLayoutFormComponentValuesBase extends PoP_Module_Processor_TriggerLayoutFormComponentValuesBase
{
    public function getTriggerTypeDataResolverClass(array $module)
    {
        return ConvertiblePostTypeDataResolver::class;
    }
}
