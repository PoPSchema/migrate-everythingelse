<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

trait GD_UserCommunities_CreateUpdate_Profile_Trait
{
    protected function getFormData(&$data_properties)
    {
        return array_merge(
            parent::getFormData($data_properties),
            $this->getUsercommunitiesFormData()
        );
    }
    protected function getUsercommunitiesFormData()
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
        $inputs = GD_UserCommunities_MyCommunitiesUtils::getFormInputs();
        $communities = $moduleprocessor_manager->getProcessor($inputs['communities'])->getValue($inputs['communities']);
        return array(
            'communities' => $communities ?? array(),
        );
    }

    protected function additionalsCreate($user_id, $form_data)
    {
        parent::additionalsCreate($user_id, $form_data);
        $this->usercommunitiesAdditionalsCreate($user_id, $form_data);
    }
    protected function usercommunitiesAdditionalsCreate($user_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_custom_createupdate_profile:additionalsCreate', $user_id, $form_data);
    }

    protected function createuser(&$errors, $form_data)
    {
        $user_id = parent::createuser($errors, $form_data);
        $this->usercommunitiesCreateuser($user_id, $errors, $form_data);
        return $user_id;
    }
    protected function usercommunitiesCreateuser($user_id, &$errors, $form_data)
    {
        $communities = $form_data['communities'];
        \PoP\UserMeta\Utils::updateUserMeta($user_id, GD_URE_METAKEY_PROFILE_COMMUNITIES, $communities);
                
        // Set the privileges/tags for the new communities
        gdUreUserAddnewcommunities($user_id, $communities);
    }
}
