<?php

class GD_DataLoad_ActionExecuter_Create_Event extends GD_DataLoad_ActionExecuter_CreateUpdate_Event
{
    public function getMutationResolverClass(): string
    {
        return GD_Create_Event::class;
    }

    protected function isUpdate(): bool
    {
        return false;
    }
}

