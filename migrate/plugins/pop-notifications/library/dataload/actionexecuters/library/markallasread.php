<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class GD_NotificationMarkAllAsRead extends AbstractMutationResolver
{
    protected function additionals($form_data)
    {
        HooksAPIFacade::getInstance()->doAction('GD_NotificationMarkAllAsRead:additionals', $form_data);
    }

    protected function markAllAsRead($form_data)
    {

        // return AAL_Main::instance()->api->setStatusMultipleNotifications($form_data['user_id'], AAL_POP_STATUS_READ);
        return PoP_Notifications_API::setStatusMultipleNotifications($form_data['user_id'], AAL_POP_STATUS_READ);
    }

    public function execute(array $form_data)
    {
        $hist_ids = $this->markAllAsRead($form_data);
        $this->additionals($form_data);

        return $hist_ids;
    }
}
