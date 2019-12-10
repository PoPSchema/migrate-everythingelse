<?php
use PoP\Hooks\Facades\HooksAPIFacade;
/*
Plugin Name: PoP Pages Web Platform
Description: Implementation of EventLinks Creation Web Platform for PoP
Plugin URI: https://getpop.org
Version: 0.1
Author: Leonardo Losovizen/u/leo/
*/

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_PAGESWEBPLATFORM_VERSION', 0.132);
define('POP_PAGESWEBPLATFORM_DIR', dirname(__FILE__));

class PoP_PagesWebPlatform
{
    public function __construct()
    {

        // Priority: after PoP Application Web Platform
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 510);
    }
    public function init()
    {
        define('POP_PAGESWEBPLATFORM_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_PAGESWEBPLATFORM_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_PagesWebPlatform_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_PagesWebPlatform_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_PagesWebPlatform();
