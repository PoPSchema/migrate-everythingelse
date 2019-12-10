<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_MultiDomain_Engine_Utils
{
    public static function addVars($vars_in_array)
    {
        $vars = &$vars_in_array[0];
        $vars['domain'] = $_REQUEST[POP_URLPARAM_DOMAIN];

        // Add the external URL's domain, only if we are on the External Page
        if ($vars['routing-state']['is-standard'] && $vars['route'] == POP_MULTIDOMAIN_ROUTE_EXTERNAL) {
            if ($external_url = $_REQUEST[GD_URLPARAM_URL]) {
                $vars['external-url-domain'] = getDomain($external_url);
            }
        }
    }

    public static function addModuleInstanceComponents($components)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        if ($domain = $vars['domain']) {
            $components[] = TranslationAPIFacade::getInstance()->__('domain:', 'pop-multidomain').\PoP\ComponentModel\Utils::getDomainId($domain);
        }
        // External domain different configuration: needed for the resourceLoader config.js file to load, cached in the list under pop-cache/resources/,
        // which is different for different domains
        if ($external_url_domain = $vars['external-url-domain']) {
            $components[] = TranslationAPIFacade::getInstance()->__('external url domain:', 'pop-multidomain').\PoP\ComponentModel\Utils::getDomainId($external_url_domain);
        }

        return $components;
    }
}

/**
 * Initialization
 */
HooksAPIFacade::getInstance()->addAction('\PoP\ComponentModel\Engine_Vars:addVars', array(PoP_MultiDomain_Engine_Utils::class, 'addVars'), 10, 1);
HooksAPIFacade::getInstance()->addFilter(\PoP\ComponentModel\ModelInstance\ModelInstance::HOOK_COMPONENTS_RESULT, array(PoP_MultiDomain_Engine_Utils::class, 'addModuleInstanceComponents'));
