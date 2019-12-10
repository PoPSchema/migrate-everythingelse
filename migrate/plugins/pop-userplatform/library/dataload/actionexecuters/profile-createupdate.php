<?php

class GD_DataLoad_ActionExecuter_CreateUpdate_Profile extends GD_DataLoad_ActionExecuter_CreateUpdate_UserBase
{
    public function getCreateupdate()
    {
        return new GD_CreateUpdate_Profile();
    }
}
    
