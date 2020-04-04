<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\ComponentModel\Misc\GeneralUtils;

class PoP_ActionExecuterInstance_ContactUs
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

        if (empty($form_data['message'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Message cannot be empty.', 'pop-genericforms');
        }
    }

    /**
     * Function to override
     */
    protected function additionals($form_data)
    {
        HooksAPIFacade::getInstance()->doAction('pop_contactus', $form_data);
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data = array(
            'name' => $moduleprocessor_manager->getProcessor([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME])->getValue([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME]),
            'email' => $moduleprocessor_manager->getProcessor([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_EMAIL])->getValue([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_EMAIL]),
            'subject' => $moduleprocessor_manager->getProcessor([PoP_ContactUs_Module_Processor_TextFormInputs::class, PoP_ContactUs_Module_Processor_TextFormInputs::MODULE_FORMINPUT_SUBJECT])->getValue([PoP_ContactUs_Module_Processor_TextFormInputs::class, PoP_ContactUs_Module_Processor_TextFormInputs::MODULE_FORMINPUT_SUBJECT]),
            'message' => $moduleprocessor_manager->getProcessor([PoP_ContactUs_Module_Processor_TextareaFormInputs::class, PoP_ContactUs_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_MESSAGE])->getValue([PoP_ContactUs_Module_Processor_TextareaFormInputs::class, PoP_ContactUs_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_MESSAGE]),
        );
        
        return $form_data;
    }

    protected function execute($form_data)
    {
        $cmsapplicationapi = \PoP\Application\FunctionAPIFactory::getInstance();
        $to = PoP_EmailSender_Utils::getAdminNotificationsEmail();
        $subject = sprintf(
            TranslationAPIFacade::getInstance()->__('[%s]: %s', 'pop-genericforms'),
            $cmsapplicationapi->getSiteName(),
            TranslationAPIFacade::getInstance()->__('Contact us', 'pop-genericforms')
        );
        $placeholder = '<p><b>%s:</b> %s</p>';
        $msg = sprintf(
            '<p>%s</p>',
            TranslationAPIFacade::getInstance()->__('New contact us submission', 'pop-genericforms')
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Name', 'pop-genericforms'),
            $form_data['name']
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Email', 'pop-genericforms'),
            sprintf(
                '<a href="mailto:%1$s">%1$s</a>',
                $form_data['email']
            )
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Subject', 'pop-genericforms'),
            $form_data['subject']
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Message', 'pop-genericforms'),
            $form_data['message']
        );

        return PoP_EmailSender_Utils::sendEmail($to, $subject, $msg);
    }

    public function contactus(&$errors, &$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        $this->validate($errors, $form_data);
        if ($errors) {
            return;
        }

        $result = $this->execute($form_data);
        if (GeneralUtils::isError($result)) {
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
