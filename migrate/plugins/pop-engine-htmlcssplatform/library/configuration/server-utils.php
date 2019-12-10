<?php

class PoP_HTMLCSSPlatform_ServerUtils
{
    public static function loadDynamicallyGeneratedResourceFiles()
    {
        return isset($_ENV['LOAD_DYNAMICALLY_GENERATED_RESOURCE_FILES']) ? strtolower($_ENV['LOAD_DYNAMICALLY_GENERATED_RESOURCE_FILES']) == "true" : false;
    }

    public static function useMinifiedResources()
    {
        return isset($_ENV['USE_MINIFIED_RESOURCES']) ? strtolower($_ENV['USE_MINIFIED_RESOURCES']) == "true" : false;
    }

    public static function accessExternalcdnResources()
    {
        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('externalcdn');
        if (!is_null($override)) {
            return $override;
        }

        return isset($_ENV['ACCESS_EXTERNAL_CDN_RESOURCES']) ? strtolower($_ENV['ACCESS_EXTERNAL_CDN_RESOURCES']) == "true" : false;
    }

    public static function throwExceptionOnTemplateError()
    {
        return isset($_ENV['THROW_EXCEPTION_ON_TEMPLATE_ERROR']) ? strtolower($_ENV['THROW_EXCEPTION_ON_TEMPLATE_ERROR']) == "true" : false;
    }

    public static function useBundledResources()
    {
        // Allow to override the configuration
        $override = \PoP\ComponentModel\Server\Utils::getOverrideConfiguration('app-bundle');
        if (!is_null($override)) {
            return $override;
        }

        return isset($_ENV['USE_BUNDLED_RESOURCES']) ? strtolower($_ENV['USE_BUNDLED_RESOURCES']) == "true" : false;
    }
}
