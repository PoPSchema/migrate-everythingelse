<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_NotificationMarkAsReadUnread
{
    protected function getFormData(&$data_properties)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $form_data = array(
            'histid' => $_REQUEST[$this->getRequestKey()],
            'user_id' => $vars['global-userstate']['current-user-id'],
        );
        
        return $form_data;
    }

    protected function getRequestKey()
    {
        return 'nid';
    }

    protected function validate(&$errors, $form_data)
    {
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

    public function execute(&$errors, &$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        $this->validate($errors, $form_data);
        if ($errors) {
            return;
        }

        $hist_ids = $this->setStatus($form_data);
        $this->additionals($form_data['histid'], $form_data);

        return $hist_ids; //$form_data['histid'];
    }
}
