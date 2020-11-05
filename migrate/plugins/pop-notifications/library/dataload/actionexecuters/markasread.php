<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;
use PoP\ComponentModel\Facades\MutationResolution\MutationResolutionManagerFacade;

class GD_DataLoad_ActionExecuter_NotificationMarkAsRead implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_NotificationMarkAsRead();
    }

    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
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
        $gd_dataload_actionexecution_manager = MutationResolutionManagerFacade::getInstance();
        $gd_dataload_actionexecution_manager->setResult(get_called_class(), $hist_ids);

        // No errors => success
        return array(
            ResponseConstants::SUCCESS => true
        );
    }
}

