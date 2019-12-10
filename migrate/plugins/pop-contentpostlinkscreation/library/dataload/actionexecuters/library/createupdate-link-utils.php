<?php
use PoP\Translation\Facades\TranslationAPIFacade;

class Wassup_CreateUpdate_Link_Utils
{
    public static function validatecontent(&$errors, $form_data)
    {
        if (empty($form_data['content'])) {
            // The link will be the content. So then replace the error message if the content (link) is empty
            // Add the error message at the beginning, since the Link input is shown before the Title input
            array_splice($errors, array_search(TranslationAPIFacade::getInstance()->__('The content cannot be empty', 'poptheme-wassup'), $errors), 1);
            array_unshift($errors, TranslationAPIFacade::getInstance()->__('The link cannot be empty', 'poptheme-wassup'));
        } else {
            // the content is actually the external URL, so validate it has a right format
            if (!isValidUrl($form_data['content'])) {
                array_unshift($errors, TranslationAPIFacade::getInstance()->__('Invalid Link URL', 'poptheme-wassup'));
            }
        }
    }
}
