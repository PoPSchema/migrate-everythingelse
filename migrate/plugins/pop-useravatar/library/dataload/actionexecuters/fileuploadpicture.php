<?php

use PoP\ComponentModel\State\ApplicationState;

class GD_DataLoad_ActionExecuter_FileUploadPicture implements \PoP\ComponentModel\ComponentMutationResolverBridgeInterface
{
    public function execute(&$data_properties)
    {

        // Copy the images to the fileupload-userphoto upload folder
        $vars = ApplicationState::getVars();
        $gd_fileupload_userphoto = GD_FileUpload_UserPhotoFactory::getInstance();
        $user_id = $vars['global-userstate']['current-user-id'];
        $gd_fileupload_userphoto->copyPicture($user_id);

        return null;
    }
}

