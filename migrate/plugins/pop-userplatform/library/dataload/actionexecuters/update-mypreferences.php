<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_UpdateMyPreferences implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_UpdateMyPreferences();
    }

    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
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

