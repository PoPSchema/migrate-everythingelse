<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_Volunteer extends GD_DataLoad_FormActionExecuterBase
{
    protected function getInstance()
    {
        return new PoP_ActionExecuterInstance_Volunteer();
    }

    public function executeForm(&$data_properties)
    {
        $instance = $this->getInstance();
        $result = $instance->volunteer($data_properties);
        if (\PoP\ComponentModel\GeneralUtils::isError($result)) {
            return array(
                ResponseConstants::ERRORSTRINGS => $result->getErrorMessages()
            );
        }
        
        // No errors => success
        return array(
            ResponseConstants::SUCCESS => true
        );
    }
}
    
