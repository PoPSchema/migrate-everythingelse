<?php

class PoPWebPlatform_Taxonomies_Module_SettingsProcessor extends PoP_WebPlatformEngine_Module_SettingsProcessorBase
{
    use \PoP\Taxonomies\SettingsProcessor_Trait;
    use PoPWebPlatform_Taxonomies_Module_SettingsProcessor_Trait;
}

/**
 * Initialization
 */
new PoPWebPlatform_Taxonomies_Module_SettingsProcessor();
