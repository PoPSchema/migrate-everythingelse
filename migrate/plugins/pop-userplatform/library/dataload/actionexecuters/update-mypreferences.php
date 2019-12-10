<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_UpdateMyPreferences implements \PoP\ComponentModel\ActionExecuterInterface
{
    protected function getInstance()
    {
        return new GD_UpdateMyPreferences();
    }

    public function execute(&$data_properties)
    {
        $errors = array();
        $instance = $this->getInstance();
        $instance->execute($errors, $data_properties);

        if ($errors) {
            return array(
                ResponseConstants::ERRORSTRINGS => $errors
            );
        }
        
        // No errors => success
        return array(
            ResponseConstants::SUCCESS => true,
        );
    }
}
    
