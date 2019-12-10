<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_ShareByEmail extends GD_DataLoad_FormActionExecuterBase
{
    protected function getInstance()
    {
        return new PoP_ActionExecuterInstance_ShareByEmail();
    }

    public function executeForm(&$data_properties)
    {
        $errors = array();
        $instance = $this->getInstance();
        $instance->share($errors);

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
    
