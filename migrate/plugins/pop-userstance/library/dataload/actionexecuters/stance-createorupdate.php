<?php
use PoPSchema\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;

class PoP_UserStance_DataLoad_ActionExecuter_CreateOrUpdate_Stance extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_CreateOrUpdate_Stance::class;
    }
}

