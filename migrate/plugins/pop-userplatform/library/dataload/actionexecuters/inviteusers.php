<?php

class GD_DataLoad_ActionExecuter_InviteUsers extends GD_DataLoad_ActionExecuter_EmailInviteBase
{
    protected function getInstance()
    {
        return new GD_InviteUsers();
    }
}
    
