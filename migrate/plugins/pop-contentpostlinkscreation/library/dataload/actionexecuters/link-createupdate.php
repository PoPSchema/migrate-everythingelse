<?php

class GD_DataLoad_ActionExecuter_CreateUpdate_ContentPostLink extends GD_DataLoad_ActionExecuter_CreateUpdate_PostBase
{
    public function getCreateupdate()
    {
        return new GD_CreateUpdate_PostLink();
    }
}
    
