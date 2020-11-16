<?php
use PoPSitesWassup\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;

class PoP_UserStance_DataLoad_ActionExecuter_Update_Stance extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Update_Stance::class;
    }

    protected function isUpdate(): bool
    {
        return true;
    }
}

