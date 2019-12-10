<?php
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

abstract class GD_URE_Module_Processor_MembersLayoutsBase extends PoP_Module_Processor_SubcomponentLayoutsBase
{
    public function getSubcomponentField(array $module)
    {
        return 'members';
    }

    public function getSubcomponentTypeDataResolverClass(array $module)
    {
        return UserTypeDataResolver::class;
    }
}
