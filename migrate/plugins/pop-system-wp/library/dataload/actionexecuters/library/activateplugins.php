<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\Info\ApplicationInfoFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class GD_ActivatePlugins extends AbstractMutationResolver
{
    // Taken from https://wordpress.stackexchange.com/questions/4041/how-to-activate-plugins-via-code
    private function runActivatePlugin($plugin)
    {
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $current = $cmsengineapi->getOption('active_plugins');
        $plugin = plugin_basename(trim($plugin));

        if (!in_array($plugin, $current)) {
            $current[] = $plugin;
            sort($current);
            HooksAPIFacade::getInstance()->doAction('activate_plugin', trim($plugin));
            update_option('active_plugins', $current);
            HooksAPIFacade::getInstance()->doAction('activate_' . trim($plugin));
            HooksAPIFacade::getInstance()->doAction('activated_plugin', trim($plugin));
            return true;
        }

        return false;
    }

    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        // Plugins needed by the website. Check the website version, if it's the one indicated,
        // then proceed to install the required plugin
        $plugin_version = HooksAPIFacade::getInstance()->applyFilters(
            'PoP:system-activateplugins:plugins',
            array()
        );

        // Iterate all plugins and check what version they require to be installed. If it matches the current version => activate
        $version = ApplicationInfoFacade::getInstance()->getVersion();
        $activated = [];
        foreach ($plugin_version as $plugin => $activate_version) {
            if ($activate_version == $version) {
                if ($this->runActivatePlugin("${plugin}/${plugin}.php")) {
                    $activated[] = $plugin;
                }
            }
        }

        return $activated;
    }
}
