<?php
use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\State\ApplicationState;

abstract class GD_DataLoad_ActionExecuter_NotificationMarkAsReadUnread extends AbstractComponentMutationResolverBridge
{
    public function getFormData(): array
    {
        $vars = ApplicationState::getVars();
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
}

