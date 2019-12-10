<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class PoP_WebPlatformEngineOptimizations_ServerUtils
{
    public static function extractResponseIntoJsfilesOnRuntime()
    {
        if (PoP_WebPlatform_ServerUtils::disableJs()) {
            return false;
        }

        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('runtime-js');
        if (!is_null($override)) {
            return $override;
        }

        // Even if set as true, there are requests that cannot generate resources on runtime
        // Eg: the AppShell, or otherwise we must also cache the corresponding /settings/ .js files,
        // which we can't obtain when generating the service-worker.js file
        if (HooksAPIFacade::getInstance()->applyFilters('extractResponseIntoJsfilesOnRuntime:skip', false)) {
            return false;
        }

        return isset($_ENV['EXTRACT_RESPONSE_INTO_JS_FILES_ON_RUNTIME']) ? strtolower($_ENV['EXTRACT_RESPONSE_INTO_JS_FILES_ON_RUNTIME']) == "true" : false;
    }
}
