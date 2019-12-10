<?php

class GD_DataLoad_ActionExecuter_CreateUpdate_EventLink extends GD_DataLoad_ActionExecuter_CreateUpdate_Event
{
    public function getCreateupdate()
    {
        return new GD_CreateUpdate_EventLink();
    }
}
    
