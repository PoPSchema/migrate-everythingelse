<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class GD_FileUploadPicture extends AbstractMutationResolver
{
    public function execute(array $form_data)
    {
        // Copy the images to the fileupload-userphoto upload folder
        $user_id = $form_data['user_id'];
        $gd_fileupload_userphoto = GD_FileUpload_UserPhotoFactory::getInstance();
        $gd_fileupload_userphoto->copyPicture($user_id);

        return null;
    }
}