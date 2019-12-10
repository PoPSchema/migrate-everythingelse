<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_ServiceWorkers_WebPlatformEngine_Hooks
{
    public function __construct()
    {
        HooksAPIFacade::getInstance()->addFilter('extractResponseIntoJsfilesOnRuntime:skip', array($this, 'maybeSkipExtractResponseIntoJsfilesOnRuntime'));
    }

    public function maybeSkipExtractResponseIntoJsfilesOnRuntime($skip)
    {

        // Indicate for what pages we can't do extractResponseIntoJsfilesOnRuntime
        // Eg: the AppShell, or otherwise we must also cache the corresponding /settings/ .js files,
        // which we can't obtain when generating the service-worker.js file
        // if (\PoP\ComponentModel\Utils::isPage(POP_ENGINEWEBPLATFORM_ROUTE_APPSHELL)) {
        if (\PoP\ComponentModel\Utils::isRoute(POP_ENGINEWEBPLATFORM_ROUTE_APPSHELL)) {
            return true;
        }

        return $skip;
    }
}

/**
 * Initialization
 */
new PoP_ServiceWorkers_WebPlatformEngine_Hooks();
