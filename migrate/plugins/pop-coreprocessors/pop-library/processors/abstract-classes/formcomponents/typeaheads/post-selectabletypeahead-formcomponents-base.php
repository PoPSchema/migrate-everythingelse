<?php
use PoP\CustomPosts\TypeHelpers\CustomPostUnionTypeHelpers;
use PoP\CustomPosts\TypeResolvers\CustomPostUnionTypeResolver;

abstract class PoP_Module_Processor_PostSelectableTypeaheadFormComponentsBase extends PoP_Module_Processor_SelectableTypeaheadFormComponentsBase
{
    public function getTriggerTypeResolverClass(array $module): ?string
    {
        return CustomPostUnionTypeHelpers::getCustomPostUnionOrTargetTypeResolverClass(CustomPostUnionTypeResolver::class);
    }
}
