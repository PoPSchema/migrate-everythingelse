<?php

class PoP_DataQuery_PostHook extends \PoP\Posts\DataQuery_PostHookBase
{
    public function getNoCacheFields()
    {
        return array(
            'recommendedby',
            'recommendpost-count',
            'recommendpost-count-plus1',
            'upvotepost-count',
            'upvotepost-count-plus1',
            'downvotepost-count',
            'downvotepost-count-plus1',
        );
    }
}

/**
 * Initialization
 */
new PoP_DataQuery_PostHook();
