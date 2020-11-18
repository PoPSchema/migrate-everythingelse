<?php
use PoPSitesWassup\CustomPostMutations\MutationResolverBridges\AbstractCreateUpdateCustomPostMutationResolverBridge;

class GD_DataLoad_ActionExecuter_Create_LocationPostLink extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Create_LocationPostLink::class;
    }

    protected function isUpdate(): bool
    {
        return false;
    }
}

