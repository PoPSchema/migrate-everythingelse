<?php

class PoP_UserStanceWP_WP_DataLoad_ActionExecuter_CreateOrUpdate_Stance extends PoP_UserStance_DataLoad_ActionExecuter_CreateOrUpdate_Stance
{
    public function getMutationResolverClass(): string
    {
        return GD_WP_CreateOrUpdate_Stance::class;
    }
}

/**
 * Initialize
 */
if (!\PoP\ComponentModel\Server\Utils::disableCustomCMSCode()) {
	new PoP_UserStanceWP_WP_DataLoad_ActionExecuter_CreateOrUpdate_Stance();
}
