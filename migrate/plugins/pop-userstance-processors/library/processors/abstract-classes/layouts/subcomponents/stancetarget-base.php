<?php
use PoP\Posts\TypeResolvers\PostConvertibleTypeResolver;

abstract class PoP_Module_Processor_StanceTargetSubcomponentLayoutsBase extends PoP_Module_Processor_SubcomponentLayoutsBase
{
    public function getSubcomponentField(array $module)
    {
        return 'stancetarget';
    }

    public function getSubcomponentTypeResolverClass(array $module)
    {
        return PostConvertibleTypeResolver::class;
    }
}
