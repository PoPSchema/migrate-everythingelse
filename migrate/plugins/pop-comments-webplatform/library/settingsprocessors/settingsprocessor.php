<?php

class PoPWebPlatform_Comments_Module_SettingsProcessor extends PoP_WebPlatformEngine_Module_SettingsProcessorBase
{
    use \PoP\Comments\SettingsProcessor_Trait;
    use PoPWebPlatform_Comments_Module_SettingsProcessor_Trait;
}

/**
 * Initialization
 */
new PoPWebPlatform_Comments_Module_SettingsProcessor();
