<?php
class PoP_UsersWebPlatform_Initialization
{
    public function initialize()
    {
        load_plugin_textdomain('pop-users-webplatform', false, dirname(plugin_basename(__FILE__)).'/languages');

        /**
         * Load the PoP Library
         */
        include_once 'library/load.php';
    }
}
