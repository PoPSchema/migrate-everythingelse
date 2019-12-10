<?php

class GD_DataLoad_ActionExecuter_CreateUpdate_ProfileOrganization extends GD_DataLoad_ActionExecuter_CreateUpdate_Profile
{
    public function getCreateupdate()
    {
        if (defined('POP_USERCOMMUNITIES_INITIALIZED')) {
            return new GD_CommonUserRole_UserCommunities_CreateUpdate_ProfileOrganization();
        }

        return new GD_CreateUpdate_ProfileOrganization();
    }
}
    
