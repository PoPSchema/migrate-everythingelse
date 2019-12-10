<?php
namespace PoP\UserState\Settings;

abstract class DefaultSettingsProcessorBase extends SettingsProcessorBase
{
    public function init()
    {
        parent::init();

        SettingsProcessorManagerFactory::getInstance()->setDefault($this);
    }

    public function requiresUserState()
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $route = $vars['route'];

        // Check if the page has checkpoints. If so, assume it requires user state
        if ($checkpoints = \PoP\ComponentModel\Settings\SettingsManagerFactory::getInstance()->getCheckpoints($route)) {
            return !empty($checkpoints);
        }

        return parent::requiresUserState();
    }
}
