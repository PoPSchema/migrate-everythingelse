<?php
/*
Plugin Name: PoP CMS Model Processors
Version: 0.1
Description: Collection of processors for PoP CMS Model
Plugin URI: https://getpop.org/
Author: Leonardo Losoviz
*/
use PoP\Hooks\Facades\HooksAPIFacade;

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_CMSMODELPROCESSORS_VERSION', 0.229);
define('POP_CMSMODELPROCESSORS_DIR', dirname(__FILE__));

class PoP_CMSModelProcessors
{
    public function __construct()
    {
        
        // Priority: after PoP Master Collection Processors
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 709);
    }
    public function init()
    {
        define('POP_CMSMODELPROCESSORS_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_CMSMODELPROCESSORS_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_CMSModelProcessors_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_CMSModelProcessors_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_CMSModelProcessors();
