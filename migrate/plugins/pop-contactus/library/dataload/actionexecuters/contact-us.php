<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_ContactUs extends GD_DataLoad_FormActionExecuterBase
{
    protected function getInstance()
    {
        return new PoP_ActionExecuterInstance_ContactUs();
    }

    public function executeForm(&$data_properties)
    {
        $errors = array();
        $instance = $this->getInstance();
        $instance->contactus($errors, $data_properties);

        if ($errors) {
            return array(
                ResponseConstants::ERRORSTRINGS => $errors
            );
        }
        
        // No errors => success
        return array(
            ResponseConstants::SUCCESS => true
        );
    }
}
    
