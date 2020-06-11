<?php
use PoP\ComponentModel\TypeResolvers\UnionTypeHelpers;
use PoP\CustomPosts\TypeResolvers\CustomPostUnionTypeResolver;

abstract class PoP_Module_Processor_PostSelectableTypeaheadFormComponentsBase extends PoP_Module_Processor_SelectableTypeaheadFormComponentsBase
{
    public function getTriggerTypeResolverClass(array $module): ?string
    {
        return UnionTypeHelpers::getUnionOrTargetTypeResolverClass(CustomPostUnionTypeResolver::class);
    }
}
