<?php
use PoP\Translation\Facades\TranslationAPIFacade;

class GD_FormInput_ModeratedStatus extends \PoP\Engine\GD_FormInput_MultiSelect
{
    public function getAllValues($label = null)
    {
        $values = parent::getAllValues($label);
        
        $values = array_merge(
            $values,
            array(
                POP_POSTSTATUS_DRAFT => TranslationAPIFacade::getInstance()->__('Draft', 'pop-coreprocessors'),
                POP_POSTSTATUS_PENDING => TranslationAPIFacade::getInstance()->__('Pending to be published', 'pop-coreprocessors'),
                POP_POSTSTATUS_PUBLISHED => TranslationAPIFacade::getInstance()->__('Published', 'pop-coreprocessors')
            )
        );
        
        return $values;
    }
}
