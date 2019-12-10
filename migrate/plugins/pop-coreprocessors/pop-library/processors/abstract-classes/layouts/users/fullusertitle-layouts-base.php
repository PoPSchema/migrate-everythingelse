<?php

abstract class PoP_Module_Processor_FullUserTitleLayoutsBase extends PoP_Module_Processor_FullObjectTitleLayoutsBase
{
    public function getTitleField(array $module, array &$props)
    {
        return 'display-name';
    }
    
    public function getTitleConditionField(array $module, array &$props)
    {
        return 'is-profile';
    }
}
