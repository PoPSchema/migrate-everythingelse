<?php

class GD_DataLoad_ActionExecuter_InviteMembers extends GD_DataLoad_ActionExecuter_EmailInviteBase
{
    public function getMutationResolverClass(): string
    {
        return GD_InviteMembers::class;
    }
}

