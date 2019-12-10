<?php
class PoP_PagesProcessors_Initialization
{
    public function initialize()
    {
        load_plugin_textdomain('pop-pages-processors', false, dirname(plugin_basename(__FILE__)).'/languages');

        /**
         * Load the PoP Library
         */
        include_once 'library/load.php';
    }
}
