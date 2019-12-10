<?php

class PoPWebPlatform_Posts_Module_SettingsProcessor extends PoP_WebPlatformEngine_Module_SettingsProcessorBase
{
    use \PoP\Posts\SettingsProcessor_Trait;
    use PoPWebPlatform_Posts_Module_SettingsProcessor_Trait;
}

/**
 * Initialization
 */
new PoPWebPlatform_Posts_Module_SettingsProcessor();
