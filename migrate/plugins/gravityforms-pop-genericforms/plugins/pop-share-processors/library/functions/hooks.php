<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_Share_GFHooks
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
        if ($form_id == PoP_Share_GFHelpers::getSharebyemailFormId()) {
            return PoP_Share_GFHelpers::getSharebyemailFormFieldNames();
        }
        
        return $fieldnames;
    }
}
    
/**
 * Initialize
 */
new PoP_Share_GFHooks();
