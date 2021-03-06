<?php
class PoP_ContentCreation_Initialization
{
    public function initialize()
    {
        load_plugin_textdomain('pop-contentcreation', false, dirname(plugin_basename(__FILE__)).'/languages');

        /**
         * Load the Config
         */
        include_once 'config/load.php';

        /**
         * Load the Library
         */
        include_once 'library/load.php';

        /**
         * Load the Plugins library
         */
        include_once 'plugins/load.php';
    }
}
