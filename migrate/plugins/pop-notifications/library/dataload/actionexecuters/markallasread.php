<?php
use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\State\ApplicationState;

class GD_DataLoad_ActionExecuter_NotificationMarkAllAsRead extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_NotificationMarkAllAsRead::class;
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }
    public function getFormData(): array
    {
        $vars = ApplicationState::getVars();
        $form_data = array(
            'user_id' => $vars['global-userstate']['current-user-id'],
        );

        return $form_data;
    }
}

