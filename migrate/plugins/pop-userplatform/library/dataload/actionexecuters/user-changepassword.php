<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_ChangePassword_User implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_ChangePassword_User();
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
            $instance->changepassword($errors);

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

        return null;
    }
}

