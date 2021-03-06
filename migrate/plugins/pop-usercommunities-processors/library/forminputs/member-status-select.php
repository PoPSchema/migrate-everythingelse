<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Engine\FormInputs\SelectFormInput;

class GD_URE_FormInput_MemberStatus extends SelectFormInput
{
    public function getAllValues($label = null)
    {
        $values = parent::getAllValues($label);

        $values = array_merge(
            $values,
            array(
                GD_URE_METAVALUE_PROFILE_COMMUNITIES_MEMBERSTATUS_ACTIVE => TranslationAPIFacade::getInstance()->__('Active', 'ure-popprocessors'),
                GD_URE_METAVALUE_PROFILE_COMMUNITIES_MEMBERSTATUS_REJECTED => TranslationAPIFacade::getInstance()->__('Rejected', 'ure-popprocessors'),
            )
        );

        return $values;
    }
}
