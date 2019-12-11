<?php
use PoP\Posts\TypeResolvers\PostConvertibleTypeResolver;

abstract class PoP_Module_Processor_ReferencesLayoutsBase extends PoP_Module_Processor_SubcomponentLayoutsBase
{
    public function getSubcomponentField(array $module)
    {
        return 'references';
    }

    public function getSubcomponentTypeResolverClass(array $module)
    {
        return PostConvertibleTypeResolver::class;
    }
}
