<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_SubscribeToUnsubscribeFromTag extends GD_UpdateUserMetaValue
{
    protected function validate(&$errors, $form_data)
    {
        parent::validate($errors, $form_data);

        if (!$errors) {
            $target_id = $form_data['target_id'];

            // Make sure the post exists
            $tagapi = \PoPSchema\Tags\FunctionAPIFactory::getInstance();
            $target = $tagapi->getTag($target_id);
            if (!$target) {
                $errors[] = TranslationAPIFacade::getInstance()->__('The requested topic/tag does not exist.', 'pop-coreprocessors');
            }
        }
    }

    protected function getRequestKey()
    {
        return POP_INPUTNAME_TAGID;
    }

    protected function additionals($target_id, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('gd_subscritetounsubscribefrom_tag', $target_id, $form_data);
        parent::additionals($target_id, $form_data);
    }
}
