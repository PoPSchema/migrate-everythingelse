<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoPSitesWassup\GravityFormsMutations\MutationResolverBridges\GravityFormsComponentMutationResolverBridge;

class PoP_Volunteering_GFHooks
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
        if ($form_id == PoP_Volunteering_GFHelpers::getVolunteerFormId()) {
            return PoP_Volunteering_GFHelpers::getVolunteerFormFieldNames();
        }

        return $fieldnames;
    }
}

/**
 * Initialize
 */
new PoP_Volunteering_GFHooks();
