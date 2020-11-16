<?php

class GD_DataLoad_ActionExecuter_Update_LocationPost extends GD_DataLoad_ActionExecuter_CreateUpdate_LocationPost
{
    public function getMutationResolverClass(): string
    {
        return GD_Update_LocationPost::class;
    }

    protected function isUpdate(): bool
    {
        return true;
    }
}

