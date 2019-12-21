<?php
use PoP\Posts\TypeResolvers\ContentEntityUnionTypeResolver;

abstract class PoP_Module_Processor_PostTriggerLayoutFormComponentValuesBase extends PoP_Module_Processor_TriggerLayoutFormComponentValuesBase
{
    public function getTriggerTypeResolverClass(array $module): ?string
    {
        return ContentEntityUnionTypeResolver::class;
    }
}
