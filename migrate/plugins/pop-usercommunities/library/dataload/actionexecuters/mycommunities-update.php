<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_Update_MyCommunities implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_Update_MyCommunities();
    }

    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
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

