<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_Newsletter_GFHooks
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
        if ($form_id == PoP_Newsletter_GFHelpers::getNewsletterFormId()) {
            return PoP_Newsletter_GFHelpers::getNewsletterFormFieldNames();
        }
        
        return $fieldnames;
    }
}
    
/**
 * Initialize
 */
new PoP_Newsletter_GFHooks();
