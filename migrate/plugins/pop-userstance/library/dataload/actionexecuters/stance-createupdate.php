<?php

class PoP_UserStance_DataLoad_ActionExecuter_CreateUpdate_Stance extends GD_DataLoad_ActionExecuter_CreateUpdate_PostBase
{
    public function getCreateupdate()
    {
        return new GD_CreateUpdate_Stance();
    }
}
    
