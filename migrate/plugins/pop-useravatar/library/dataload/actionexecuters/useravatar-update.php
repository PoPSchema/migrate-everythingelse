<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_UserAvatar_Update implements ComponentMutationResolverBridgeInterface
{
    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $gd_useravatar_update = GD_UserAvatar_UpdateFactory::getInstance();
            $errors = array();
            $gd_useravatar_update->save($errors, $data_properties);

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

