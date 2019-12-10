<?php
use PoP\Hooks\Facades\HooksAPIFacade;

/**
 * Ignore files to cache: all the ones with checkpoint needed
 */
HooksAPIFacade::getInstance()->addFilter('pop_wp_cache_set_rejected_uri', 'gdWpCacheSetRejectedUriCheckpoints');
function gdWpCacheSetRejectedUriCheckpoints($rejected_uris)
{
    $settingsmanager = \PoP\UserState\Settings\SettingsManagerFactory::getInstance();
    foreach (\PoP\ComponentModel\Settings\SettingsProcessorManagerFactory::getInstance()->getRoutes() as $route) {
        // $checkpoint_configuration = $settingsmanager->getCheckpointConfiguration($page);
        // if (\PoP\ComponentModel\Utils::isServerAccessMandatory($checkpoint_configuration)) {
        if ($settingsmanager->requiresUserState($route)) {
            $rejected_uris[] = '/'.$route.'/';
        }
    }

    return $rejected_uris;
}
