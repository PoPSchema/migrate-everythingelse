<?php

class PoPWebPlatform_Users_Module_SettingsProcessor extends PoP_WebPlatformEngine_Module_SettingsProcessorBase
{
    use \PoP\Users\SettingsProcessor_Trait;
    use PoPWebPlatform_Users_Module_SettingsProcessor_Trait;
}

/**
 * Initialization
 */
new PoPWebPlatform_Users_Module_SettingsProcessor();
