<?php
class PoP_PostsProcessors_Initialization
{
    public function initialize()
    {
        load_plugin_textdomain('pop-posts-processors', false, dirname(plugin_basename(__FILE__)).'/languages');

        /**
         * Load the PoP Library
         */
        include_once 'library/load.php';
    }
}
