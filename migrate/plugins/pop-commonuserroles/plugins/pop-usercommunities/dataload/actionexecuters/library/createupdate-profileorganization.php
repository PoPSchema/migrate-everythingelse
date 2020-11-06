<?php

class GD_CommonUserRole_UserCommunities_CreateUpdate_ProfileOrganization extends GD_UserCommunities_CreateUpdate_Profile
{
    use GD_CreateUpdate_ProfileOrganization_Trait;

    protected function createupdateuser($user_id, $form_data)
    {
        parent::createupdateuser($user_id, $form_data);
        $this->commonuserrolesCreateupdateuser($user_id, $form_data);

        // Is community?
        $cmsuserrolesapi = \PoPSchema\UserRoles\FunctionAPIFactory::getInstance();
        if ($form_data['is_community']) {
            $cmsuserrolesapi->addRoleToUser($user_id, GD_URE_ROLE_COMMUNITY);
        } else {
            $cmsuserrolesapi->removeRoleFromUser($user_id, GD_URE_ROLE_COMMUNITY);
        }
    }
}
