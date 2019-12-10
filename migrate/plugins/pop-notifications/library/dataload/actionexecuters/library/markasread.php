<?php

class GD_NotificationMarkAsRead extends GD_NotificationMarkAsReadUnread
{
    protected function getStatus()
    {
        return AAL_POP_STATUS_READ;
    }
}
