<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_NotificationMarkAsUnread extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_NotificationMarkAsUnread::class;
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }
}

