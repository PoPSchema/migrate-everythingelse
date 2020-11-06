<?php

class GD_DataLoad_ActionExecuter_NotificationMarkAsRead extends GD_DataLoad_ActionExecuter_NotificationMarkAsReadUnread
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

