<?php
use PoPSitesWassup\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;

class GD_DataLoad_ActionExecuter_Update_LocationPostLink extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Update_LocationPostLink::class;
    }

    protected function isUpdate(): bool
    {
        return true;
    }
}

