<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_NotificationMarkAllAsRead
{
    protected function getFormData(&$data_properties)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $form_data = array(
            'user_id' => $vars['global-userstate']['current-user-id'],
        );
        
        return $form_data;
    }

    protected function additionals($form_data)
    {
        HooksAPIFacade::getInstance()->doAction('GD_NotificationMarkAllAsRead:additionals', $form_data);
    }

    protected function markAllAsRead($form_data)
    {

        // return AAL_Main::instance()->api->setStatusMultipleNotifications($form_data['user_id'], AAL_POP_STATUS_READ);
        return PoP_Notifications_API::setStatusMultipleNotifications($form_data['user_id'], AAL_POP_STATUS_READ);
    }

    public function execute(&$errors, &$data_properties)
    {
        $form_data = $this->getFormData($data_properties);

        $hist_ids = $this->markAllAsRead($form_data);
        $this->additionals($form_data);

        return $hist_ids;
    }
}
