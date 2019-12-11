<?php
use PoP\Posts\TypeResolvers\PostConvertibleTypeResolver;

abstract class PoP_Module_Processor_PostSelectableTypeaheadFormComponentsBase extends PoP_Module_Processor_SelectableTypeaheadFormComponentsBase
{
    public function getTriggerTypeResolverClass(array $module): ?string
    {
        return PostConvertibleTypeResolver::class;
    }
}
