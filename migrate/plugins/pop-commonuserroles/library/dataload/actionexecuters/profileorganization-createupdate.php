<?php

class GD_DataLoad_ActionExecuter_CreateUpdate_ProfileOrganization extends GD_DataLoad_ActionExecuter_CreateUpdate_Profile
{
    use GD_DataLoad_ActionExecuter_CreateUpdate_ProfileOrganization_Trait;

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

    public function getFormData(): array
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
        $inputs = $this->getFormInputs();
        return array_merge(
            parent::getFormData(),
            $this->getCommonuserrolesFormData(),
            array(
                'is_community' => (bool)$moduleprocessor_manager->getProcessor($inputs['is_community'])->getValue($inputs['is_community']),
            )
        );
    }

    public function getMutationResolverClass(): string
    {
        if (defined('POP_USERCOMMUNITIES_INITIALIZED')) {
            return GD_CommonUserRole_UserCommunities_CreateUpdate_ProfileOrganization::class;
        }

        return GD_CreateUpdate_ProfileOrganization::class;
    }
}

