<?php
use PoPSchema\PostMutations\MutationResolvers\AbstractCreateUpdatePostMutationResolverBridge;

class PoP_UserStance_DataLoad_ActionExecuter_CreateOrUpdate_Stance extends AbstractCreateUpdatePostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_CreateOrUpdate_Stance::class;
    }
}

