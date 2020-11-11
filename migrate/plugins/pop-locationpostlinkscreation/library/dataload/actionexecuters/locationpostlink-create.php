<?php
use PoPSitesWassup\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;

class GD_DataLoad_ActionExecuter_Create_LocationPostLink extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Create_LocationPostLink::class;
    }
}

