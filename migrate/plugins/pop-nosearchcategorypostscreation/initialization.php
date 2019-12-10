<?php
class PoP_NoSearchCategoryPostsCreation_Initialization
{
    public function initialize()
    {
        load_plugin_textdomain('pop-nosearchcategorypostscreation', false, dirname(plugin_basename(__FILE__)).'/languages');

        /**
         * Constants/Configuration for functionalities needed by the plug-in
         */
        include_once 'config/load.php';

        /**
         * Load the PoP Library
         */
        include_once 'library/load.php';
    }
}
