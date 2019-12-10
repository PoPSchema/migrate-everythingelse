<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

HooksAPIFacade::getInstance()->addFilter(\PoP\ComponentModel\ModelInstance\ModelInstance::HOOK_COMPONENTS_RESULT, 'popThemeModuleInstanceComponents');
function popThemeModuleInstanceComponents($components)
{
    $vars = \PoP\ComponentModel\Engine_Vars::getVars();

    if ($theme = $vars['theme']) {
        $components[] = TranslationAPIFacade::getInstance()->__('theme:', 'pop-engine').$theme;
    }
    if ($thememode = $vars['thememode']) {
        $components[] = TranslationAPIFacade::getInstance()->__('thememode:', 'pop-engine').$thememode;
    }
    if ($themestyle = $vars['themestyle']) {
        $components[] = TranslationAPIFacade::getInstance()->__('themestyle:', 'pop-engine').$themestyle;
    }

    return $components;
}
