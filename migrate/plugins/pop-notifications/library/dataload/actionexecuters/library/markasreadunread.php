<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class GD_NotificationMarkAsReadUnread extends AbstractMutationResolver
{
    public function validateErrors(array $form_data): ?array
    {
        $errors = [];
        $histid = $form_data['histid'];
        if (!$histid) {
            $errors[] = TranslationAPIFacade::getInstance()->__('This URL is incorrect.', 'pop-notifications');
        } else {
            // $notification = AAL_Main::instance()->api->getNotification($histid);
            $notification = PoP_Notifications_API::getNotification($histid);
            if (!$notification) {
                $errors[] = TranslationAPIFacade::getInstance()->__('This notification does not exist.', 'pop-notifications');
            }
        }
        return $errors;
    }

    protected function additionals($histid, $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('GD_NotificationMarkAsReadUnread:additionals', $histid, $form_data);
    }

    /**
     * Function to override
     */
    protected function getStatus()
    {

        // Notice that null is also "Mark as Unread"
        return null;
    }

    protected function setStatus($form_data)
    {

        // return AAL_Main::instance()->api->setStatus($form_data['histid'], $form_data['user_id'], $this->getStatus());
        return PoP_Notifications_API::setStatus($form_data['histid'], $form_data['user_id'], $this->getStatus());
    }

    public function execute(array $form_data)
    {
        $hist_ids = $this->setStatus($form_data);
        $this->additionals($form_data['histid'], $form_data);

        return $hist_ids; //$form_data['histid'];
    }
}
