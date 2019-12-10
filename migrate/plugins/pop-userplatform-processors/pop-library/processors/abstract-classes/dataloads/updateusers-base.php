<?php
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

abstract class PoP_Module_Processor_UpdateUserDataloadsBase extends PoP_Module_Processor_CreateUpdateUserDataloadsBase
{
    public function getDBObjectIDOrIDs(array $module, array &$props, &$data_properties)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        return $vars['global-userstate']['current-user-id'];
    }

    public function getTypeDataResolverClass(array $module): ?string
    {
        return UserTypeDataResolver::class;
    }
}
