<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoPSitesWassup\GravityFormsMutations\MutationResolverBridges\GravityFormsComponentMutationResolverBridge;

class PoP_SocialNetwork_GFHooks
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
        if ($form_id == PoP_SocialNetwork_GFHelpers::getContactuserFormId()) {
            return PoP_SocialNetwork_GFHelpers::getContactuserFormFieldNames();
        }

        return $fieldnames;
    }
}

/**
 * Initialize
 */
new PoP_SocialNetwork_GFHooks();
