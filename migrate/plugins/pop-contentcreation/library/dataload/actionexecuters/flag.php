<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_Flag extends GD_DataLoad_FormActionExecuterBase
{
    protected function getInstance()
    {
        return new PoP_ActionExecuterInstance_Flag();
    }

    public function executeForm(&$data_properties)
    {
        $errors = array();
        $instance = $this->getInstance();
        $instance->flag($errors, $data_properties);

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
    
