<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_NotificationMarkAsRead extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_NotificationMarkAsRead::class;
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }
}

