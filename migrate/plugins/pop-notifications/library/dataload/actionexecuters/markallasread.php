<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_NotificationMarkAllAsRead implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_NotificationMarkAllAsRead();
    }

    public function execute(&$data_properties)
    {
        $errors = array();
        $instance = $this->getInstance();
        $hist_ids = $instance->execute($errors, $data_properties);

        if ($errors) {
            return array(
                ResponseConstants::ERRORSTRINGS => $errors
            );
        }

        // Save the result for some module to incorporate it into the query args
        $gd_dataload_actionexecution_manager = \PoP\ComponentModel\ActionExecutionManagerFactory::getInstance();
        $gd_dataload_actionexecution_manager->setResult(get_called_class(), $hist_ids);

        // No errors => success
        return array(
            ResponseConstants::SUCCESS => true
        );
    }
}

