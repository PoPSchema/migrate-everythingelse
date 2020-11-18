<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoPSitesWassup\GravityFormsMutations\MutationResolverBridges\GravityFormsComponentMutationResolverBridge;

class PoP_ContactUs_GFHooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter(
            GravityFormsComponentMutationResolverBridge::HOOK_FORM_FIELDNAMES,
            array($this, 'getFieldnames'),
            10,
            2
        );
    }

    public function getFieldnames($fieldnames, $form_id)
    {
        if ($form_id == PoP_ContactUs_GFHelpers::getContactusFormId()) {
            return PoP_ContactUs_GFHelpers::getContactusFormFieldNames();
        }

        return $fieldnames;
    }
}

/**
 * Initialize
 */
new PoP_ContactUs_GFHooks();
