<?php

/**
 * user meta
 */

function gdGetUserShortdescription($user_id)
{
    return \PoP\UserMeta\Utils::getUserMeta($user_id, GD_METAKEY_PROFILE_SHORTDESCRIPTION, true);
}
