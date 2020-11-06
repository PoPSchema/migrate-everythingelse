<?php
class GD_DataLoad_ActionExecuter_Volunteer extends GD_DataLoad_FormActionExecuterBase
{
    public function getMutationResolverClass(): string
    {
        return PoP_ActionExecuterInstance_Volunteer::class;
    }
}

