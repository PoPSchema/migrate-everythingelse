<?php
use PoP\Translation\Facades\TranslationAPIFacade;

class PoP_GF_UnsubscribeFromNewsletter extends PoP_UnsubscribeFromNewsletter
{
    protected function validateData(&$errors, $newsletter_data)
    {
        parent::validateData($errors, $newsletter_data);

        if (empty($newsletter_data['entry-id'])) {
            $errors[] = TranslationAPIFacade::getInstance()->__('Your email is not subscribed to our newsletter.', 'gravityforms-pop-genericforms');
        }
    }

    protected function getNewsletterData($form_data)
    {
        $ret = parent::getNewsletterData($form_data);

        // Find the entry_id from the email (let's assume there is only one. If there is more than one, that is the user subscribed more than once, so will have to unsubscribe more than once. HOhohoho)
        $entry_id = $form_data['email'];
        $search_criteria = array(
            'status' => 'active',
            'field_filters' => array(
                array(
                    'key' => '1'/*POP_GENERICFORMS_NEWSLETTER_FIELDNAME_EMAIL_ID*/,
                    'value' => $form_data['email'],
                ),
            ),
        );
        $entries = GFAPI::get_entries(PoP_Newsletter_GFHelpers::getNewsletterFormId(), $search_criteria);
        if (!$entries) {
            return array();
        }
        $entry = $entries[0];
        $ret['entry-id'] = $entries[0]['id'];

        return $ret;
    }

    protected function execute($newsletter_data)
    {
        return GFAPI::delete_entry($newsletter_data['entry-id']);
    }
}
