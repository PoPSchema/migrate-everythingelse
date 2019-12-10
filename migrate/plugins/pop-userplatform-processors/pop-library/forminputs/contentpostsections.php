<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_FormInput_PostSections extends \PoP\Engine\GD_FormInput_MultiSelect
{
    public function getAllValues($label = null)
    {
        $values = parent::getAllValues($label);

        foreach (PoP_Application_Utils::getContentpostsectionCats() as $cat) {
            $values[$cat] = HooksAPIFacade::getInstance()->applyFilters('GD_FormInput_PostSections:cat:name', gdGetCategoryname($cat), $cat);
        }
        
        return $values;
    }
}
