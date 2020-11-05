<?php

class GD_DataLoad_ActionExecuter_Update_Highlight extends GD_DataLoad_ActionExecuter_CreateUpdate_Highlight
{
    public function getMutationResolverClass(): string
    {
        return GD_Update_Highlight::class;
    }
}

