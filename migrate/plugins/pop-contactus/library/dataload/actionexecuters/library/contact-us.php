<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class PoP_ActionExecuterInstance_ContactUs extends AbstractMutationResolver
{
    public function validate(array $form_data): ?array
    {
        $errors = [];
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
        return $errors;
    }

    /**
     * Function to override
     */
    protected function additionals($form_data)
    {
        HooksAPIFacade::getInstance()->doAction('pop_contactus', $form_data);
    }

    protected function doExecute($form_data)
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

    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        $result = $this->doExecute($form_data);
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
