<?php
/*
Plugin Name: PoP Pages Processors
Version: 0.1
Description: Collection of processors for PoP Pages
Plugin URI: https://getpop.org/
Author: Leonardo Losoviz
*/
use PoP\Hooks\Facades\HooksAPIFacade;

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_PAGESPROCESSORS_VERSION', 0.229);
define('POP_PAGESPROCESSORS_DIR', dirname(__FILE__));

class PoP_PagesProcessors
{
    public function __construct()
    {
        
        // Priority: after PoP Master Collection Processors
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 710);
    }
    public function init()
    {
        define('POP_PAGESPROCESSORS_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_PAGESPROCESSORS_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_PagesProcessors_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_PagesProcessors_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_PagesProcessors();
