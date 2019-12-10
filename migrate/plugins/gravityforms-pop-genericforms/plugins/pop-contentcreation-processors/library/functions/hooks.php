<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_ContentCreation_GFHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            'GD_DataLoad_ActionExecuter_GravityForms:fieldnames',
            array($this, 'getFieldnames'),
            10,
            2
        );
    }

    public function getFieldnames($fieldnames, $form_id)
    {
        if ($form_id == PoP_ContentCreation_GFHelpers::getFlagFormId()) {
            return PoP_ContentCreation_GFHelpers::getFlagFormFieldNames();
        }
        
        return $fieldnames;
    }
}
    
/**
 * Initialize
 */
new PoP_ContentCreation_GFHooks();
