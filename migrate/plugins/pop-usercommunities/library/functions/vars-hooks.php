<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter(\PoP\ComponentModel\ModelInstance\ModelInstance::HOOK_COMPONENTS_RESULT, 'gdUreModuleInstanceComponents');
function gdUreModuleInstanceComponents($components)
{

    // Add source param for Communities: view their profile as Community or personal
    $vars = \PoP\ComponentModel\Engine_Vars::getVars();
    if ($vars['routing-state']['is-user']) {
        $author = $vars['routing-state']['queried-object-id'];
        if (gdUreIsCommunity($author)) {
            $vars = \PoP\ComponentModel\Engine_Vars::getVars();
            if ($source = $vars['source']) {
                $components[] = TranslationAPIFacade::getInstance()->__('source:', 'pop-usercommunities').$source;
            }
        }
    }

    return $components;
}
