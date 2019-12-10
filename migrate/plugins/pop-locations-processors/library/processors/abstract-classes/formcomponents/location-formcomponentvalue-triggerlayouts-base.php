<?php
use PoP\Locations\TypeDataResolvers\LocationTypeDataResolver;

abstract class PoP_Module_Processor_LocationTriggerLayoutFormComponentValuesBase extends PoP_Module_Processor_TriggerLayoutFormComponentValuesBase
{
    public function getTriggerTypeDataResolverClass(array $module)
    {
        return LocationTypeDataResolver::class;
    }
}
