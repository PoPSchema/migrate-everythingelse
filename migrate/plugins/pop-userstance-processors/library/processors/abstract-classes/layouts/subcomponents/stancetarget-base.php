<?php
use PoP\Posts\TypeDataResolvers\ConvertiblePostTypeDataResolver;

abstract class PoP_Module_Processor_StanceTargetSubcomponentLayoutsBase extends PoP_Module_Processor_SubcomponentLayoutsBase
{
    public function getSubcomponentField(array $module)
    {
        return 'stancetarget';
    }

    public function getSubcomponentTypeDataResolverClass(array $module)
    {
        return ConvertiblePostTypeDataResolver::class;
    }
}
