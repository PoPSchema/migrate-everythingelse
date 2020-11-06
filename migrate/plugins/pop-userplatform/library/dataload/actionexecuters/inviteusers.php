<?php

class GD_DataLoad_ActionExecuter_InviteUsers extends GD_DataLoad_ActionExecuter_EmailInviteBase
{
    public function getMutationResolverClass(): string
    {
        return GD_InviteUsers::class;
    }
}

