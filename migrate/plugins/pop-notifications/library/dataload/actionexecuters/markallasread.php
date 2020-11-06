<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

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
}

