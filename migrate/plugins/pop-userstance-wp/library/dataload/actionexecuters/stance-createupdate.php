<?php

class PoP_UserStanceWP_WP_DataLoad_ActionExecuter_CreateUpdate_Stance extends PoP_UserStance_DataLoad_ActionExecuter_CreateUpdate_Stance
{
    public function getCreateupdate()
    {
        return new GD_WP_CreateUpdate_Stance();
    }
}
    
/**
 * Initialize
 */
if (!\PoP\ComponentModel\Server\Utils::disableCustomCMSCode()) {
	new PoP_UserStanceWP_WP_DataLoad_ActionExecuter_CreateUpdate_Stance();
}
