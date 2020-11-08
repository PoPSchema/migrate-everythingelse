<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class PoP_ActionExecuterInstance_SubscribeToNewsletter extends AbstractMutationResolver
{
    public function validate(array $form_data): ?array
    {
        $errors = [];
        if (empty($form_data['email'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Email cannot be empty.', 'pop-genericforms');
        } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Email format is incorrect.', 'pop-genericforms');
        }
        return $errors;
    }

    /**
     * Function to override
     */
    protected function additionals($form_data)
    {
        HooksAPIFacade::getInstance()->doAction('pop_subscribetonewsletter', $form_data);
    }

    protected function doExecute($form_data)
    {
        $cmsapplicationapi = \PoP\Application\FunctionAPIFactory::getInstance();
        $to = PoP_EmailSender_Utils::getAdminNotificationsEmail();
        $subject = sprintf(
            TranslationAPIFacade::getInstance()->__('[%s]: %s', 'pop-genericforms'),
            $cmsapplicationapi->getSiteName(),
            TranslationAPIFacade::getInstance()->__('Newsletter Subscription', 'pop-genericforms')
        );
        $placeholder = '<p><b>%s:</b> %s</p>';
        $msg = sprintf(
            '<p>%s</p>',
            TranslationAPIFacade::getInstance()->__('User subscribed to newsletter', 'pop-genericforms')
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Email', 'pop-genericforms'),
            sprintf(
                '<a href="mailto:%1$s">%1$s</a>',
                $form_data['email']
            )
        ).sprintf(
            $placeholder,
            TranslationAPIFacade::getInstance()->__('Name', 'pop-genericforms'),
            $form_data['name']
        );

        return PoP_EmailSender_Utils::sendEmail($to, $subject, $msg);
    }

    public function execute(array $form_data)
    {
        $result = $this->doExecute($form_data);

        // Allow for additional operations
        $this->additionals($form_data);

        return $result;
    }
}
