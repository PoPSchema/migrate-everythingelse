<?php
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class GD_NotificationMarkAllAsRead implements MutationResolverInterface
{
    protected function getFormData()
    {
        $vars = ApplicationState::getVars();
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

    public function execute(array &$errors, array &$errorcodes)
    {
        $form_data = $this->getFormData();

        $hist_ids = $this->markAllAsRead($form_data);
        $this->additionals($form_data);

        return $hist_ids;
    }
}
