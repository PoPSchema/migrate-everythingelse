<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_EditMembership implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_EditMembership();
    }

    public function execute(&$data_properties)
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $errors = array();
            $instance = $this->getInstance();
            $instance->execute($errors, $data_properties);

            if ($errors) {
                return array(
                    ResponseConstants::ERRORSTRINGS => $errors
                );
            }

            return array(
                ResponseConstants::SUCCESS => true
            );
        }

        return null;
    }
}

