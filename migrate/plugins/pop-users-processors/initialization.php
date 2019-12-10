<?php
class PoP_UsersProcessors_Initialization
{
    public function initialize()
    {
        load_plugin_textdomain('pop-users-processors', false, dirname(plugin_basename(__FILE__)).'/languages');

        /**
         * Load the PoP Library
         */
        include_once 'library/load.php';
    }
}
