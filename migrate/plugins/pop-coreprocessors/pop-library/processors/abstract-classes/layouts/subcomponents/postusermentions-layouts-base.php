<?php
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

abstract class PoP_Module_Processor_PostUserMentionsLayoutsBase extends PoP_Module_Processor_SubcomponentLayoutsBase
{
    public function getSubcomponentField(array $module)
    {
        return 'taggedusers';
    }

    public function getSubcomponentTypeDataResolverClass(array $module)
    {
        return UserTypeDataResolver::class;
    }
}
