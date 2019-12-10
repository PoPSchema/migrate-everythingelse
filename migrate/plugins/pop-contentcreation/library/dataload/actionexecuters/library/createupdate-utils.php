<?php
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_CreateUpdate_Utils
{
    public static function moderate()
    {

        // Global constant defining if posts in the website can be created straight or subject to moderation
        return HooksAPIFacade::getInstance()->applyFilters('GD_CreateUpdate_Utils:moderate', false);
    }

    public static function getUpdatepostStatus($status, $moderate)
    {
        $statuses = [
            POP_POSTSTATUS_PUBLISHED, 
            POP_POSTSTATUS_DRAFT,
        ];
        if ($moderate) {
            $statuses[] = POP_POSTSTATUS_PENDING;
        }

        // Status: Validate the value only is one of the following ones
        if (!in_array($status, $statuses)) {
            $status = POP_POSTSTATUS_DRAFT;
        }
        
        // When moderating, if the status is publish, then do nothing (so it won't override the existing 'publish' status), and then it can't be hacked by passing this value in the $_POST
        if ($moderate && ($status == POP_POSTSTATUS_PUBLISHED)) {
            return null;
        }

        return $status;
    }
    public static function getCreatepostStatus($status, $moderate)
    {
        $statuses = [
            POP_POSTSTATUS_DRAFT,
        ];
        if ($moderate) {
            // If moderating, cannot publish straight, goes to pending instead
            $statuses[] = POP_POSTSTATUS_PENDING;
        } else {
            // If not moderating, 2 values available: draft or publish
            $statuses[] = POP_POSTSTATUS_PUBLISHED;
        }

        // Status: Validate the value only is one of the following ones
        if (!in_array($status, $statuses)) {
            $status = POP_POSTSTATUS_DRAFT;
        }

        return $status;
    }
}
