<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;

class PoP_UnsubscribeFromNewsletter
{
    protected function validate(&$errors, $form_data)
    {
        if (empty($form_data['email'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Email cannot be empty.', 'pop-genericforms');
        } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Email format is incorrect.', 'pop-genericforms');
        }

        $placeholder_string = TranslationAPIFacade::getInstance()->__('%s %s', 'pop-genericforms');
        $makesure_string = TranslationAPIFacade::getInstance()->__('Please make sure you have clicked on the unsubscription link in the newsletter.', 'pop-genericforms');
        if (empty($form_data['verificationcode'])) {
            $errors[] = sprintf(
                $placeholder_string,
                TranslationAPIFacade::getInstance()->__('The verification code is missing.', 'pop-genericforms'),
                $makesure_string
            );
        }

        if ($errors) {
            return;
        }

        // Verify that the verification code corresponds to the email
        $verificationcode = PoP_GenericForms_NewsletterUtils::getEmailVerificationcode($form_data['email']);
        if ($verificationcode != $form_data['verificationcode']) {
            $errors[] = sprintf(
                $placeholder_string,
                TranslationAPIFacade::getInstance()->__('The verification code does not match the email.', 'pop-genericforms'),
                $makesure_string
            );
        }
    }

    /**
     * Function to override
     */
    protected function additionals($form_data)
    {
        HooksAPIFacade::getInstance()->doAction('pop_unsubscribe_from_newsletter', $form_data);
    }

    protected function getFormData(&$data_properties)
    {
        $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();

        $form_data = array(
            'email' => $moduleprocessor_manager->getProcessor([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAILVERIFICATIONEMAIL])->getValue([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAILVERIFICATIONEMAIL]),
            'verificationcode' => $moduleprocessor_manager->getProcessor([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAILVERIFICATIONCODE])->getValue([PoP_Newsletter_Module_Processor_TextFormInputs::class, PoP_Newsletter_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NEWSLETTEREMAILVERIFICATIONCODE]),
        );
        
        return $form_data;
    }

    /**
     * Function to override by Gravity Forms
     */
    protected function getNewsletterData($form_data)
    {
        return array();
    }
    /**
     * Function to override by Gravity Forms
     */
    protected function validateData(&$errors, $newsletter_data)
    {
    }

    protected function execute($newsletter_data)
    {
        $cmsapplicationapi = \PoP\Application\FunctionAPIFactory::getInstance();
        $to = PoP_EmailSender_Utils::getAdminNotificationsEmail();
        $subject = sprintf(
            TranslationAPIFacade::getInstance()->__('[%s]: Newsletter unsubscription', 'pop-genericforms'),
            $cmsapplicationapi->getSiteName()
        );
        $placeholder = '<p><b>%s:</b> %s</p>';
        $msg = sprintf(
            '<p>%s</p>',
            TranslationAPIFacade::getInstance()->__('User unsubscribed from newsletter', 'pop-genericforms')
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Email', 'pop-genericforms'),
            $newsletter_data['email']
        );

        return PoP_EmailSender_Utils::sendEmail($to, $subject, $msg);
        // return GFAPI::delete_entry($newsletter_data['entry-id']);
    }

    public function unsubscribe(&$errors, &$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        $this->validate($errors, $form_data);
        if ($errors) {
            return;
        }

        $newsletter_data = $this->getNewsletterData($form_data);
        $this->validateData($errors, $newsletter_data);
        if ($errors) {
            return;
        }

        $result = $this->execute($newsletter_data);
        // if (GeneralUtils::isError($result)) {
        //     foreach ($result->getErrorMessages() as $error_msg) {
        //         $errors[] = $error_msg;
        //     }
        //     return;
        // }

        // Allow for additional operations
        $this->additionals($form_data);

        return $result;
    }
}
