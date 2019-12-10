<?php
/*
Plugin Name: PoP Comments Processors
Version: 0.1
Description: Collection of processors for PoP Comments
Plugin URI: https://getpop.org/
Author: Leonardo Losoviz
*/
use PoP\Hooks\Facades\HooksAPIFacade;

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_COMMENTSPROCESSORS_VERSION', 0.229);
define('POP_COMMENTSPROCESSORS_DIR', dirname(__FILE__));

class PoP_CommentsProcessors
{
    public function __construct()
    {
        
        // Priority: after PoP Master Collection Processors
        HooksAPIFacade::getInstance()->addAction('plugins_loaded', array($this, 'init'), 710);
    }
    public function init()
    {
        define('POP_COMMENTSPROCESSORS_URL', plugins_url('', __FILE__));

        if ($this->validate()) {
            $this->initialize();
            define('POP_COMMENTSPROCESSORS_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        include_once 'validation.php';
        $validation = new PoP_CommentsProcessors_Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new PoP_CommentsProcessors_Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new PoP_CommentsProcessors();
