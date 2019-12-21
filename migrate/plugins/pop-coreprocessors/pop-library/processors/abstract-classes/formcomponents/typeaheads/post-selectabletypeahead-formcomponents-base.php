<?php
use PoP\Content\TypeResolvers\ContentEntityUnionTypeResolver;

abstract class PoP_Module_Processor_PostSelectableTypeaheadFormComponentsBase extends PoP_Module_Processor_SelectableTypeaheadFormComponentsBase
{
    public function getTriggerTypeResolverClass(array $module): ?string
    {
        return ContentEntityUnionTypeResolver::class;
    }
}
