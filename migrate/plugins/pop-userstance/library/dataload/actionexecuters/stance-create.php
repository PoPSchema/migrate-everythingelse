<?php
use PoPSitesWassup\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;

class PoP_UserStance_DataLoad_ActionExecuter_Create_Stance extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Create_Stance::class;
    }

    protected function isUpdate(): bool
    {
        return false;
    }
}

