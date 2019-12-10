<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_Update_MyCommunities implements \PoP\ComponentModel\ActionExecuterInterface
{
    protected function getInstance()
    {
        return new GD_Update_MyCommunities();
    }

    public function execute(&$data_properties)
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $errors = array();
            $instance = $this->getInstance();
            $updated = $instance->update($errors, $data_properties);

            // Allow for both success and errors (eg: some communities added, others not since they banned the user)
            $ret = array();
            if ($errors) {
                $ret[ResponseConstants::ERRORSTRINGS] = $errors;
            }
            if ($updated) {
                $ret[ResponseConstants::SUCCESS] = true;
            }

            return $ret;
        }

        return null;
    }
}
    
