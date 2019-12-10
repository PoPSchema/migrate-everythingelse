<?php
/*
Plugin Name: Gravity Forms for PoP
Version: 0.1
Description: Integration of plugin Gravity Forms with PoP.
Plugin URI: https://getpop.org/
Author: Leonardo Losoviz
*/
use PoP\Hooks\Facades\HooksAPIFacade;

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('GFPOP_VERSION', 0.176);

define('GFPOP_DIR', dirname(__FILE__));

class GFPoP
{
    public function __construct()
    {

        // Priority: after PoP Application
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 310);
    }

    public function init()
    {
        define('GFPOP_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('GFPOP_INITIALIZED', true);
        }
    }

    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new GFPoP_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new GFPoP_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new GFPoP();
