<?php
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

abstract class PoP_Module_Processor_UserTriggerLayoutFormComponentValuesBase extends PoP_Module_Processor_TriggerLayoutFormComponentValuesBase
{
    public function getTriggerTypeDataResolverClass(array $module)
    {
        return UserTypeDataResolver::class;
    }
}
