<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_UserAvatar_Update implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function execute(&$data_properties)
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

