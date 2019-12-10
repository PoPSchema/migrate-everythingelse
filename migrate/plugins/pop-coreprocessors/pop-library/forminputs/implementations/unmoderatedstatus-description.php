<?php
use PoP\Translation\Facades\TranslationAPIFacade;

class GD_FormInput_UnmoderatedStatusDescription extends \PoP\Engine\GD_FormInput_Select
{
    public function getAllValues($label = null)
    {
        $values = parent::getAllValues($label);
        
        $values = array_merge(
            $values,
            array(
                POP_POSTSTATUS_DRAFT => TranslationAPIFacade::getInstance()->__('Draft (still editing)', 'pop-coreprocessors'),
                POP_POSTSTATUS_PUBLISHED => TranslationAPIFacade::getInstance()->__('Already published', 'pop-coreprocessors')
            )
        );
        
        return $values;
    }
    
    public function getDefaultValue()
    {
        return POP_POSTSTATUS_DRAFT;
    }
}
