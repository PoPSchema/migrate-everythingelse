<?php

class PoP_WebPlatform_ServerUtils
{
    public static function loadDynamicallyGeneratedResourceFiles()
    {
        return PoP_HTMLCSSPlatform_ServerUtils::loadDynamicallyGeneratedResourceFiles();
    }

    public static function useMinifiedResources()
    {
        return PoP_HTMLCSSPlatform_ServerUtils::useMinifiedResources();
    }

    public static function accessExternalcdnResources()
    {
        return PoP_HTMLCSSPlatform_ServerUtils::accessExternalcdnResources();
    }

    public static function useBundledResources()
    {
        return PoP_HTMLCSSPlatform_ServerUtils::useBundledResources();
    }

    public static function useLocalStorage()
    {
        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('localstorage');
        if (!is_null($override)) {
            return $override;
        }

        return isset($_ENV['USE_LOCAL_STORAGE']) ? strtolower($_ENV['USE_LOCAL_STORAGE']) == "true" : false;
    }

    public static function useAppshell()
    {
        if (self::disableJs()) {
            return false;
        }

        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('appshell');
        if (!is_null($override)) {
            return $override;
        }

        return isset($_ENV['USE_APPSHELL']) ? strtolower($_ENV['USE_APPSHELL']) == "true" : false;
    }

    public static function useProgressiveBooting()
    {
        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('progressive-booting');
        if (!is_null($override)) {
            return $override;
        }

        return isset($_ENV['USE_PROGRESSIVE_BOOTING']) ? strtolower($_ENV['USE_PROGRESSIVE_BOOTING']) == "true" : false;
    }

    public static function disableJs()
    {
        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('disable-js');
        if (!is_null($override)) {
            return $override;
        }

        return isset($_ENV['DISABLE_JS']) ? strtolower($_ENV['DISABLE_JS']) == "true" : false;
    }
}
