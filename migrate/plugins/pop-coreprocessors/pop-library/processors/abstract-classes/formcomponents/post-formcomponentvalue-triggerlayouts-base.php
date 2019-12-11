<?php
use PoP\Posts\TypeResolvers\PostConvertibleTypeResolver;

abstract class PoP_Module_Processor_PostTriggerLayoutFormComponentValuesBase extends PoP_Module_Processor_TriggerLayoutFormComponentValuesBase
{
    public function getTriggerTypeResolverClass(array $module): ?string
    {
        return PostConvertibleTypeResolver::class;
    }
}
