<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Routing\RouteNatures;
use PoP\Pages\Routing\RouteNatures as PageRouteNatures;

class PoP_WebPlatformEngine_UtilsHooks
{
    public static function addVars($vars_in_array)
    {
        // Comment Leo 19/11/2017: when first loading the website, ask if we are using the AppShell before anything else,
        // in which case it will always be 'page' and the $post->ID set to the corresponding AppShell page ID
        if (\PoP\ComponentModel\Utils::loadingSite() && PoP_WebPlatform_ServerUtils::useAppshell()) {
            
            // Comment Leo 19/11/2017: page ID POP_ENGINEWEBPLATFORM_ROUTE_APPSHELL must be set at this plugin level, not on pop-serviceworkers
            $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
            $vars = &$vars_in_array[0];
            $vars['nature'] = RouteNatures::STANDARD;//PageRouteNatures::PAGE;
            $vars['route'] = POP_ENGINEWEBPLATFORM_ROUTE_APPSHELL;
        }
    }
    public static function getQueriedObject(array $queriedObjectList)
    {
        // Comment Leo 19/11/2017: when first loading the website, ask if we are using the AppShell before anything else,
        // in which case it will always be 'page' and the $post->ID set to the corresponding AppShell page ID
        if (\PoP\ComponentModel\Utils::loadingSite() && PoP_WebPlatform_ServerUtils::useAppshell()) {
            
            return [
                null,
                null
            ];
        }

        return $queriedObjectList;
    }

    // public static function getCurrentUrl($url) {

    // 	// For some pages, eg: Add Project, Add Event, etc, allow for multiple pages/tabs to be open, so modify their URL with a unique id
    // 	// Do it only if the URL does not already contain a '#'. Eg: the user might click 'refresh' on an Add Event page, which already contains such an id
    // 	// it also allows to go down to the marker, as in for comments
    // 	if (PoP_WebPlatform_ConfigurationUtils::isMultipleopen()) {
            
    // 		$url = PoP_WebPlatformEngine_Utils::addUniqueId($url);
    // 	}

    // 	return $url;
    // }
}

/**
 * Initialization
 */
HooksAPIFacade::getInstance()->addAction('\PoP\ComponentModel\Engine_Vars:addVars', array(PoP_WebPlatformEngine_UtilsHooks::class, 'addVars'), 1, 1); // Priority 1: execute immediately after PoP_Application_Engine_Utils, which has priority 0
HooksAPIFacade::getInstance()->addFilter('\PoP\ComponentModel\Engine_Vars:queried-object', array(PoP_WebPlatformEngine_UtilsHooks::class, 'getQueriedObject'));
// HooksAPIFacade::getInstance()->addFilter('\PoP\ComponentModel\Utils:getCurrentUrl', array(PoP_WebPlatformEngine_UtilsHooks::class, 'getCurrentUrl'));
