<?php
use PoP\Posts\TypeResolvers\PostUnionTypeResolver;

abstract class PoP_Module_Processor_PostSelectableTypeaheadFormComponentsBase extends PoP_Module_Processor_SelectableTypeaheadFormComponentsBase
{
    public function getTriggerTypeResolverClass(array $module): ?string
    {
        return PostUnionTypeResolver::class;
    }
}
