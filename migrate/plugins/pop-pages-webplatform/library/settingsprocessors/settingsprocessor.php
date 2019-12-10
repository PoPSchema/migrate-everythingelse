<?php

class PoPWebPlatform_Pages_Module_SettingsProcessor extends PoP_WebPlatformEngine_Module_SettingsProcessorBase
{
    use \PoP\Pages\SettingsProcessor_Trait;
    use PoPWebPlatform_Pages_Module_SettingsProcessor_Trait;
}

/**
 * Initialization
 */
new PoPWebPlatform_Pages_Module_SettingsProcessor();
