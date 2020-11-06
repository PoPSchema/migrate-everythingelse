<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class GD_UpdateMyPreferences implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes)
    {
        $form_data = $this->getFormData();

        $this->validate($errors, $form_data);

        if ($errors) {
            return;
        }

        return $this->executeUpdate($errors, $form_data);
    }

    protected function getFormData()
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['is-user-logged-in'] ? $vars['global-userstate']['current-user-id'] : '';
        $form_data = array(
            'user_id' => $user_id,
            // We can just get the value for any one forminput from the My Preferences form, since they all have the same name (and even if the forminput was actually removed from the form!)
            'userPreferences' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_UserProfileCheckboxFormInputs::class, PoP_Module_Processor_UserProfileCheckboxFormInputs::MODULE_FORMINPUT_EMAILNOTIFICATIONS_GENERAL_NEWPOST])->getValue([PoP_Module_Processor_UserProfileCheckboxFormInputs::class, PoP_Module_Processor_UserProfileCheckboxFormInputs::MODULE_FORMINPUT_EMAILNOTIFICATIONS_GENERAL_NEWPOST]),
        );

        return $form_data;
    }

    protected function validate(&$errors, &$form_data)
    {
    }

    protected function executeUpdate(&$errors, $form_data)
    {
        $user_id = $form_data['user_id'];
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_USERPREFERENCES, $form_data['userPreferences']);

        return true;
    }
}

