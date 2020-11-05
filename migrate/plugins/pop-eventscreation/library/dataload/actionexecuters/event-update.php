<?php

class GD_DataLoad_ActionExecuter_Update_Event extends GD_DataLoad_ActionExecuter_CreateUpdate_Event
{
    public function getMutationResolverClass(): string
    {
        return GD_Update_Event::class;
    }
}

