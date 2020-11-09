<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

trait GD_DataLoad_ActionExecuter_CreateUpdate_ProfileIndividual_Trait
{
    use GD_UserCommunities_CreateUpdate_Profile_Trait;

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

    public function getFormData(): array
    {
        return array_merge(
            parent::getFormData(),
            $this->getCommonuserrolesFormData(),
            $this->getUsercommunitiesFormData()
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
}