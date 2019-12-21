<?php
use PoP\ComponentModel\TypeResolvers\UnionTypeHelpers;
use PoP\Content\TypeResolvers\ContentEntityUnionTypeResolver;

abstract class PoP_Module_Processor_PostTriggerLayoutFormComponentValuesBase extends PoP_Module_Processor_TriggerLayoutFormComponentValuesBase
{
    public function getTriggerTypeResolverClass(array $module): ?string
    {
        return UnionTypeHelpers::getUnionOrTargetTypeResolverClass(ContentEntityUnionTypeResolver::class);
    }
}
