<?php
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
abstract class PoP_Module_Processor_FullViewTitleLayoutsBase extends PoP_Module_Processor_FullObjectTitleLayoutsBase
{
    public function getTitleField(array $module, array &$props)
    {
        return 'title';
    }
    
    public function getTitleattrField(array $module, array &$props)
    {
        return 'alt';
    }

    public function getTitleConditionField(array $module, array &$props)
    {
        return FieldQueryInterpreterFacade::getInstance()->getField('isStatus', ['status' => POP_POSTSTATUS_PUBLISHED], 'published');
    }
}
