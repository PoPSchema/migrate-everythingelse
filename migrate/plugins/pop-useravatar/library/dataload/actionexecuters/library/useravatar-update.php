<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class GD_UserAvatar_Update extends AbstractMutationResolver
{
    public function savePicture($user_id, $delete_source = false)
    {
        // Avatar
        $gd_fileupload_userphoto = GD_FileUpload_UserPhotoFactory::getInstance();
        $gd_fileupload_userphoto->savePicture($user_id, $delete_source);
    }

    public function execute(array $form_data)
    {
        $user_id = $form_data['user_id'];
        $this->savePicture($user_id);
        $this->additionals($user_id, $form_data);

        return true;
    }

    protected function additionals($user_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_useravatar_update:additionals', $user_id, $form_data);
    }
}
