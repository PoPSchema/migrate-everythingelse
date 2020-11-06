<?php

class GD_DataLoad_ActionExecuter_CreateUpdate_Profile extends GD_DataLoad_ActionExecuter_CreateUpdate_UserBase
{
    public function getMutationResolverClass(): string
    {
        return GD_CreateUpdate_Profile::class;
    }
}

