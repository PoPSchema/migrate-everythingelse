<?php

class GD_DataLoad_ActionExecuter_CreateUpdate_LocationPostLink extends GD_DataLoad_ActionExecuter_CreateUpdate_PostBase
{
    public function getCreateupdate()
    {
        return new GD_CreateUpdate_LocationPostLink();
    }
}
    
