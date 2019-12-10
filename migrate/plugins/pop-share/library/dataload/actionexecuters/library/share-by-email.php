<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class PoP_ActionExecuterInstance_ShareByEmail
{
    protected function validate(&$errors, $form_data)
    {
        if (empty($form_data['name'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Your name cannot be empty.', 'pop-genericforms');
        }

        if (empty($form_data['email'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Email cannot be empty.', 'pop-genericforms');
        } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Email format is incorrect.', 'pop-genericforms');
        }

        if (empty($form_data['target-url'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The shared-page URL cannot be empty.', 'pop-genericforms');
        }

        if (empty($form_data['target-title'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('The shared-page title cannot be empty.', 'pop-genericforms');
        }
    }

    /**
     * Function to override
     */
    protected function additionals($form_data)
    {
        HooksAPIFacade::getInstance()->doAction('pop_sharebyemail', $form_data);
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data = array(
            'name' => $moduleprocessor_manager->getProcessor([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME])->getValue([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME]),
            'email' => $moduleprocessor_manager->getProcessor([PoP_Share_Module_Processor_TextFormInputs::class, PoP_Share_Module_Processor_TextFormInputs::MODULE_FORMINPUT_DESTINATIONEMAIL])->getValue([PoP_Share_Module_Processor_TextFormInputs::class, PoP_Share_Module_Processor_TextFormInputs::MODULE_FORMINPUT_DESTINATIONEMAIL]),
            'message' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_TextareaFormInputs::class, PoP_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_ADDITIONALMESSAGE])->getValue([PoP_Module_Processor_TextareaFormInputs::class, PoP_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_ADDITIONALMESSAGE]),
            'target-url' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_TextFormInputs::class, PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETURL])->getValue([PoP_Module_Processor_TextFormInputs::class, PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETURL]),
            'target-title' => $moduleprocessor_manager->getProcessor([PoP_Module_Processor_TextFormInputs::class, PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETTITLE])->getValue([PoP_Module_Processor_TextFormInputs::class, PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETTITLE]),
        );
        
        return $form_data;
    }

    protected function execute($form_data)
    {
        $cmsapplicationapi = \PoP\Application\FunctionAPIFactory::getInstance();
        $subject = sprintf(
            TranslationAPIFacade::getInstance()->__('[%s]: %s', 'pop-genericforms'),
            $cmsapplicationapi->getSiteName(),
            sprintf(
                TranslationAPIFacade::getInstance()->__('%s is sharing with you: %s', 'pop-genericforms'),
                $form_data['name'],
                $form_data['target-title']
            )
        );
        $placeholder = '<p><b>%s:</b> %s</p>';
        $msg = sprintf(
            '<p>%s</p>',
            sprintf(
                TranslationAPIFacade::getInstance()->__('%s is sharing with you: <a href="%s">%s</a>', 'pop-genericforms'),
                $form_data['name'],
                $form_data['target-url'],
                $form_data['target-title']
            )
        ).($form_data['message'] ? sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Additional message', 'pop-genericforms'),
            $form_data['message']
        ) : '');

        return PoP_EmailSender_Utils::sendEmail($form_data['email'], $subject, $msg);
    }

    public function share(&$errors)
    {
        $form_data = $this->getFormData($data_properties);

        $this->validate($errors, $form_data);
        if ($errors) {
            return;
        }

        $result = $this->execute($form_data);
        if (\PoP\ComponentModel\GeneralUtils::isError($result)) {
            foreach ($result->getErrorMessages() as $error_msg) {
                $errors[] = $error_msg;
            }
            return;
        }

        // Allow for additional operations
        $this->additionals($form_data);

        return $result;
    }
}
