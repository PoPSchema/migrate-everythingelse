<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_CommonUserRole_UserCommunities_CreateUpdate_ProfileOrganization extends GD_UserCommunities_CreateUpdate_Profile
{
    use GD_CreateUpdate_ProfileOrganization_Trait;

    private function getFormInputs()
    {
        return array_merge(
            $this->getCommonuserrolesFormInputs(),
            $this->getProfileorganizationFormInputs()
        );
    }
    protected function getProfileorganizationFormInputs()
    {
        $inputs = HooksAPIFacade::getInstance()->applyFilters(
            'GD_CommonUserRole_UserCommunities_CreateUpdate_ProfileOrganization:form-inputs',
            array(
                'is_community' => null,
            )
        );

        // If any input is null, throw an exception
        $null_inputs = array_filter($inputs, 'is_null');
        if ($null_inputs) {
            throw new Exception(
                sprintf(
                    'No form inputs defined for: %s',
                    '"'.implode('", "', array_keys($null_inputs)).'"'
                )
            );
        }

        return $inputs;
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
        $inputs = $this->getFormInputs();
        return array_merge(
            parent::getFormData($data_properties),
            $this->getCommonuserrolesFormData(),
            array(
                'is_community' => (bool)$moduleprocessor_manager->getProcessor($inputs['is_community'])->getValue($inputs['is_community']),
            )
        );
    }

    protected function createupdateuser($user_id, $form_data)
    {
        parent::createupdateuser($user_id, $form_data);
        $this->commonuserrolesCreateupdateuser($user_id, $form_data);

        // Is community?
        $cmsuserrolesapi = \PoP\UserRoles\FunctionAPIFactory::getInstance();
        if ($form_data['is_community']) {
            $cmsuserrolesapi->addRoleToUser($user_id, GD_URE_ROLE_COMMUNITY);
        } else {
            $cmsuserrolesapi->removeRoleFromUser($user_id, GD_URE_ROLE_COMMUNITY);
        }
    }
}
