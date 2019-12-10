<?php

class PoP_SSR_ServerUtils
{
    public static function disableServerSideRendering()
    {
        // If disabling the JS, then we can only do server-side rendering
        if (PoP_WebPlatform_ServerUtils::disableJs()) {
            return false;
        }

        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('disable-serverside-rendering');
        if (!is_null($override)) {
            return $override;
        }

        return isset($_ENV['DISABLE_SERVER_SIDE_RENDERING']) ? strtolower($_ENV['DISABLE_SERVER_SIDE_RENDERING']) == "true" : false;
    }

    public static function removeDatabasesFromOutput()
    {
        // We only remove the code in the server-side rendering, when first loading the website. If this is not the case,
        // then there is no need for this functionality
        if (!\PoP\ComponentModel\Utils::loadingSite() || self::disableServerSideRendering()) {
            return false;
        }

        return isset($_ENV['REMOVE_DATABASES_FROM_OUTPUT']) ? strtolower($_ENV['REMOVE_DATABASES_FROM_OUTPUT']) == "true" : false;
    }

    public static function includeScriptsAfterHtml()
    {
        if (self::disableServerSideRendering()) {
            return false;
        }

        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('scripts-end');
        if (!is_null($override)) {
            return $override;
        }

        return isset($_ENV['INCLUDE_SCRIPTS_AFTER_HTML']) ? strtolower($_ENV['INCLUDE_SCRIPTS_AFTER_HTML']) == "true" : false;
    }
}
