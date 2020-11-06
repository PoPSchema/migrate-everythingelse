<?php

class GD_DataLoad_ActionExecuter_ShareByEmail extends GD_DataLoad_FormActionExecuterBase
{
    public function getMutationResolverClass(): string
    {
        return PoP_ActionExecuterInstance_ShareByEmail::class;
    }
}

