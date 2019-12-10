<?php
use PoP\Posts\TypeDataResolvers\ConvertiblePostTypeDataResolver;

abstract class PoP_Module_Processor_PostSelectableTypeaheadFormComponentsBase extends PoP_Module_Processor_SelectableTypeaheadFormComponentsBase
{
    public function getTriggerTypeDataResolverClass(array $module)
    {
        return ConvertiblePostTypeDataResolver::class;
    }
}
