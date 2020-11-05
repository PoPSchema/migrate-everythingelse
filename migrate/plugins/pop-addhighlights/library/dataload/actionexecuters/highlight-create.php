<?php

class GD_DataLoad_ActionExecuter_Create_Highlight extends GD_DataLoad_ActionExecuter_CreateUpdate_Highlight
{
    public function getMutationResolverClass(): string
    {
        return GD_Create_Highlight::class;
    }
}

