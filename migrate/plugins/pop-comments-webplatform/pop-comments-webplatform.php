<?php
use PoP\Hooks\Facades\HooksAPIFacade;
/*
Plugin Name: PoP Comments Web Platform
Description: Implementation of EventLinks Creation Web Platform for PoP
Plugin URI: https://getpop.org
Version: 0.1
Author: Leonardo Losovizen/u/leo/
*/

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_COMMENTSWEBPLATFORM_VERSION', 0.132);
define('POP_COMMENTSWEBPLATFORM_DIR', dirname(__FILE__));

class PoP_CommentsWebPlatform
{
    public function __construct()
    {

        // Priority: after PoP Application Web Platform
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 510);
    }
    public function init()
    {
        define('POP_COMMENTSWEBPLATFORM_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_COMMENTSWEBPLATFORM_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_CommentsWebPlatform_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_CommentsWebPlatform_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_CommentsWebPlatform();
