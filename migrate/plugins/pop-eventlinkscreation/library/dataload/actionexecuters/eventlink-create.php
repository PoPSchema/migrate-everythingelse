<?php

class GD_DataLoad_ActionExecuter_Create_EventLink extends GD_DataLoad_ActionExecuter_CreateUpdate_Event
{
    public function getMutationResolverClass(): string
    {
        return GD_Create_EventLink::class;
    }
}

