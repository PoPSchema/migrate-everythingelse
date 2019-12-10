<?php
namespace PoP\UserState\Settings\Impl;

class DefaultSettingsProcessor extends \PoP\UserState\Settings\DefaultSettingsProcessorBase
{
    public function routesToProcess()
    {
        return array();
    }
}

/**
 * Initialization
 */
new DefaultSettingsProcessor();
