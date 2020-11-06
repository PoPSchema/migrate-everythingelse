<?php

class GD_DataLoad_ActionExecuter_CreateUpdate_ProfileIndividual extends GD_DataLoad_ActionExecuter_CreateUpdate_Profile
{
    public function getMutationResolverClass(): string
    {
        if (defined('POP_USERCOMMUNITIES_INITIALIZED')) {
            return GD_CommonUserRole_UserCommunities_CreateUpdate_ProfileIndividual::class;
        }

        return GD_CreateUpdate_ProfileIndividual::class;
    }
}

