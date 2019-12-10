<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_UserAvatar_Update
{
    public function __construct()
    {
        GD_UserAvatar_UpdateFactory::setInstance($this);
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
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

    public function save(&$errors, &$data_properties)
    {
        $form_data = $this->getFormData($data_properties);
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

/**
 * Initialize
 */
new GD_UserAvatar_Update();
