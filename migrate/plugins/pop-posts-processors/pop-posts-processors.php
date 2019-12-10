<?php
/*
Plugin Name: PoP Posts Processors
Version: 0.1
Description: Collection of processors for PoP Posts
Plugin URI: https://getpop.org/
Author: Leonardo Losoviz
*/
use PoP\Hooks\Facades\HooksAPIFacade;

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_POSTSPROCESSORS_VERSION', 0.229);
define('POP_POSTSPROCESSORS_DIR', dirname(__FILE__));

class PoP_PostsProcessors
{
    public function __construct()
    {
        
        // Priority: after PoP Master Collection Processors
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 710);
    }
    public function init()
    {
        define('POP_POSTSPROCESSORS_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_POSTSPROCESSORS_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_PostsProcessors_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_PostsProcessors_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_PostsProcessors();
