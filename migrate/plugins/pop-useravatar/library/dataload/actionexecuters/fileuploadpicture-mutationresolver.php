<?php
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\ComponentModel\State\ApplicationState;

class GD_FileUploadPicture implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        // Copy the images to the fileupload-userphoto upload folder
        $vars = ApplicationState::getVars();
        $gd_fileupload_userphoto = GD_FileUpload_UserPhotoFactory::getInstance();
        $user_id = $vars['global-userstate']['current-user-id'];
        $gd_fileupload_userphoto->copyPicture($user_id);

        return null;
    }
}
