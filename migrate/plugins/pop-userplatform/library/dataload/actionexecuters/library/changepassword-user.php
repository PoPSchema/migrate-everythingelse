<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\Misc\GeneralUtils;

class GD_ChangePassword_User
{
    protected function validate(&$errors, $form_data)
    {
        $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
        $cmsuseraccountapi = \PoP\UserAccount\FunctionAPIFactory::getInstance();
        // Validate Password
        // Check current password really belongs to the user
        $current_password = $form_data['current_password'];
        $password = $form_data['password'];
        $repeatpassword =  $form_data['repeat_password'];

        if (!$current_password) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Please provide the current password.', 'pop-application');
        } elseif (!$cmsuseraccountapi->checkPassword($form_data['user_id'], $current_password)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Current password is incorrect.', 'pop-application');
        }
        
        if (!$password) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The password cannot be emtpy.', 'pop-application');
        } elseif (strlen($password) < 8) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The password must be at least 8 characters long.', 'pop-application');
        } else {
            if (!$repeatpassword) {
                $errors[] = TranslationAPIFacade::getInstance()->__('Please confirm the password.', 'pop-application');
            } elseif ($password !== $repeatpassword) {
                $errors[] = TranslationAPIFacade::getInstance()->__('Passwords do not match.', 'pop-application');
            }
        }
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $vars = ApplicationState::getVars();
        $user_id = $vars['global-userstate']['current-user-id'];
        $form_data = array(
            'user_id' => $user_id,
            'current_password' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::MODULE_FORMINPUT_CUU_CURRENTPASSWORD])->getValue([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::MODULE_FORMINPUT_CUU_CURRENTPASSWORD]),
            'password' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::MODULE_FORMINPUT_CUU_NEWPASSWORD])->getValue([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::MODULE_FORMINPUT_CUU_NEWPASSWORD]),
            'repeat_password' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::MODULE_FORMINPUT_CUU_NEWPASSWORDREPEAT])->getValue([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::MODULE_FORMINPUT_CUU_NEWPASSWORDREPEAT])
        );
        
        return $form_data;
    }

    protected function executeChangepassword($user_data)
    {
        $cmseditusersapi = \PoP\EditUsers\FunctionAPIFactory::getInstance();
        return $cmseditusersapi->updateUser($user_data);
    }

    protected function getChangepasswordData($form_data)
    {
        $user_data = array(
            'id' => $form_data['user_id'],
            'password' => $form_data['password']
        );

        return $user_data;
    }

    protected function changepassworduser(&$errors, $form_data)
    {
        $user_data = $this->getChangepasswordData($form_data);
        $result = $this->executeChangepassword($user_data);

        if (GeneralUtils::isError($result)) {
            $errors[] = sprintf(
                TranslationAPIFacade::getInstance()->__('Ops, there was a problem: %s', 'pop-application'),
                $result->getErrorMessage()
            );
            return;
        }

        $user_id = $user_data['ID'];

        HooksAPIFacade::getInstance()->doAction('gd_changepassword_user', $user_id, $form_data);

        return $user_id;
    }

    public function changepassword(&$errors)
    {
        $form_data = $this->getFormData($data_properties);

        $this->validate($errors, $form_data);
        if ($errors) {
            return;
        }

        // Do the password change
        return $this->changepassworduser($errors, $form_data);
    }
}
