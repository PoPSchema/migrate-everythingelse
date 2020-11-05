<?php

use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_FileUploadPicture implements ComponentMutationResolverBridgeInterface
{
    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
    {

        // Copy the images to the fileupload-userphoto upload folder
        $vars = ApplicationState::getVars();
        $gd_fileupload_userphoto = GD_FileUpload_UserPhotoFactory::getInstance();
        $user_id = $vars['global-userstate']['current-user-id'];
        $gd_fileupload_userphoto->copyPicture($user_id);

        return null;
    }
}

