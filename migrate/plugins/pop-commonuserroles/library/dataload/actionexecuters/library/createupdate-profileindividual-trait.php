<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

trait GD_CreateUpdate_ProfileIndividual_Trait
{
    private function getFormInputs()
    {
        $inputs = HooksAPIFacade::getInstance()->applyFilters(
            'GD_CreateUpdate_ProfileIndividual_Trait:form-inputs',
            array(
                'last_name' => null,
                'individualinterests' => null,
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
        return array_merge(
            parent::getFormData($data_properties),
            $this->getCommonuserrolesFormData()
        );
    }
    protected function getCommonuserrolesFormData()
    {
        $cmsapplicationhelpers = \PoP\Application\HelperAPIFactory::getInstance();
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
        $inputs = $this->getFormInputs();
        $individualinterests = $moduleprocessor_manager->getProcessor($inputs['individualinterests'])->getValue($inputs['individualinterests']);
        return array(
            'last_name' => trim($cmsapplicationhelpers->escapeAttributes($moduleprocessor_manager->getProcessor($inputs['last_name'])->getValue($inputs['last_name']))),
            'individualinterests' => $individualinterests ?? array(),
        );
    }

    protected function createuser(&$errors, $form_data)
    {
        $user_id = parent::createuser($errors, $form_data);
        $this->commonuserrolesCreateuser($user_id, $errors, $form_data);
        return $user_id;
    }
    protected function commonuserrolesCreateuser($user_id, &$errors, $form_data)
    {
        // Add the extra User Role
        $cmsuserrolesapi = \PoPSchema\UserRoles\FunctionAPIFactory::getInstance();
        $cmsuserrolesapi->addRoleToUser($user_id, GD_URE_ROLE_INDIVIDUAL);
    }

    protected function createupdateuser($user_id, $form_data)
    {
        parent::createupdateuser($user_id, $form_data);
        $this->commonuserrolesCreateupdateuser($user_id, $form_data);
    }
    protected function commonuserrolesCreateupdateuser($user_id, $form_data)
    {
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_URE_METAKEY_PROFILE_INDIVIDUALINTERESTS, $form_data['individualinterests']);
    }
}
