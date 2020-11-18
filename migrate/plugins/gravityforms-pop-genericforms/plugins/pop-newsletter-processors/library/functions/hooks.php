<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoPSitesWassup\GravityFormsMutations\MutationResolverBridges\GravityFormsComponentMutationResolverBridge;

class PoP_Newsletter_GFHooks
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
