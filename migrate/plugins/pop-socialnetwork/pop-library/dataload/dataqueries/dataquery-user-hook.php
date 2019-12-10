<?php

class PoP_DataQuery_UserHook extends \PoP\Users\DataQuery_UserHookBase
{
    public function getNoCacheFields()
    {
        return array(
            'followers-count',
            'recommendsposts',
			'followers',
			'following',
        );
    }
}

/**
 * Initialization
 */
new PoP_DataQuery_UserHook();
