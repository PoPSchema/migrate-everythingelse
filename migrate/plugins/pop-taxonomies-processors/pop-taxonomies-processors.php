<?php
/*
Plugin Name: PoP Taxonomies Processors
Version: 0.1
Description: Collection of processors for PoP Taxonomies
Plugin URI: https://getpop.org/
Author: Leonardo Losoviz
*/
use PoP\Hooks\Facades\HooksAPIFacade;

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_TAXONOMIESPROCESSORS_VERSION', 0.229);
define('POP_TAXONOMIESPROCESSORS_DIR', dirname(__FILE__));

class PoP_TaxonomiesProcessors
{
    public function __construct()
    {
        
        // Priority: after PoP Master Collection Processors
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 710);
    }
    public function init()
    {
        define('POP_TAXONOMIESPROCESSORS_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_TAXONOMIESPROCESSORS_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_TaxonomiesProcessors_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_TaxonomiesProcessors_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_TaxonomiesProcessors();
