<?php
use PoPSchema\PostMutations\MutationResolvers\AbstractCreateUpdatePostMutationResolverBridge;

class PoP_UserStance_DataLoad_ActionExecuter_Update_Stance extends AbstractCreateUpdatePostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Update_Stance::class;
    }
}

