<?php
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\State\ApplicationState;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class GD_EmailInvite implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        // We validate the captcha apart, since if it fails, then we must not send any invite to anyone (see below: email is sent even if validation fails)
        $this->validateCaptcha($errors, $form_data);

        if ($errors) {
            return;
        }

        $this->validate($errors, $form_data);

        // No need to validate for errors, because the email will be sent to all valid emails anyway,
        // so sending might fail for some emails but not others, and we give a message to the user about these
        // if ($errors) {
        //     return;
        // }

        return $this->sendInvite($errors, $form_data);
    }

    protected function validateCaptcha(&$errors, &$form_data)
    {

        // Validate the captcha
        $vars = ApplicationState::getVars();
        if (!PoP_FormUtils::useLoggedinuserData() || !$vars['global-userstate']['is-user-logged-in']) {
            $captcha = $form_data['captcha'];

            $captcha_validation = GD_Captcha::validate($captcha);
            if (GeneralUtils::isError($captcha_validation)) {
                $errors[] = $captcha_validation->getErrorMessage();
            }
        }
    }

    protected function validate(&$errors, &$form_data)
    {
        $emails = $form_data['emails'];
        $invalid_emails = array();
        foreach ($emails as $email) {
            if (!is_email($email)) {
                $invalid_emails[] = $email;
            }
        }
        if (!empty($invalid_emails)) {
            $errors[] = sprintf(
                TranslationAPIFacade::getInstance()->__('The following emails are invalid: <strong>%s</strong>', 'pop-coreprocessors'),
                implode(', ', $invalid_emails)
            );
        }

        if (empty($emails)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Email(s) cannot be empty.', 'pop-coreprocessors');
        }

        // Re-assign the non-invalid emails to the form_data
        $form_data['emails'] = array_diff($emails, $invalid_emails);
    }

    /**
     * Function to override
     */
    protected function getEmailContent($form_data)
    {
        return '';
    }
    /**
     * Function to override
     */
    protected function getEmailSubject($form_data)
    {
        return '';
    }

    protected function sendInvite(&$errors, $form_data)
    {
        $emails = $form_data['emails'];
        if (!empty($emails)) {
            $subject = $this->getEmailSubject($form_data);
            $content = $this->getEmailContent($form_data);
            PoP_EmailSender_Utils::sendemailToUsers($emails, array(), $subject, $content, true);
        }

        return $emails;
    }
}
