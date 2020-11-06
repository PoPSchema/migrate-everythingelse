<?php

class GD_DataLoad_ActionExecuter_Create_LocationPost extends GD_DataLoad_ActionExecuter_CreateUpdate_LocationPost
{
    public function getMutationResolverClass(): string
    {
        return GD_Create_LocationPost::class;
    }
}

