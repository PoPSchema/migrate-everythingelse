<?php

class GD_DataLoad_ActionExecuter_NotificationMarkAsUnread extends GD_DataLoad_ActionExecuter_NotificationMarkAsReadUnread
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

