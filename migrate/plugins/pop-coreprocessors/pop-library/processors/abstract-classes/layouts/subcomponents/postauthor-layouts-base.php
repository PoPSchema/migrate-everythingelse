<?php
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

abstract class PoP_Module_Processor_PostAuthorLayoutsBase extends PoP_Module_Processor_SubcomponentLayoutsBase
{
    public function getSubcomponentField(array $module)
    {
        return 'authors';
    }

    public function getSubcomponentTypeDataResolverClass(array $module)
    {
        return UserTypeDataResolver::class;
    }
}
