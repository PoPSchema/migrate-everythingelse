<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class GD_UserAvatar_Update implements MutationResolverInterface
{
    protected function getFormData()
    {
        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['is-user-logged-in'] ? $vars['global-userstate']['current-user-id'] : '';
        $form_data = array(
            'user_id' => $user_id,
        );

        return $form_data;
    }

    public function savePicture($user_id, $delete_source = false)
    {
        // Avatar
        $gd_fileupload_userphoto = GD_FileUpload_UserPhotoFactory::getInstance();
        $gd_fileupload_userphoto->savePicture($user_id, $delete_source);
    }

    public function execute(array &$errors, array &$errorcodes)
    {
        $form_data = $this->getFormData();
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
