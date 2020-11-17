<?php

use PoPSitesWassup\StanceMutations\MutationResolvers\CreateOrUpdateStanceMutationResolverBridge;

class PoP_UserStanceWP_WP_DataLoad_ActionExecuter_CreateOrUpdate_Stance extends CreateOrUpdateStanceMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_WP_CreateOrUpdate_Stance::class;
    }
}
