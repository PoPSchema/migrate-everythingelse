<?php
use PoP\Users\TypeResolvers\UserTypeResolver;

abstract class PoP_Module_Processor_PostUserMentionsLayoutsBase extends PoP_Module_Processor_SubcomponentLayoutsBase
{
    public function getSubcomponentField(array $module)
    {
        return 'taggedusers';
    }

    public function getSubcomponentTypeResolverClass(array $module)
    {
        return UserTypeResolver::class;
    }
}
