<?php
use PoPSchema\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;

class GD_DataLoad_ActionExecuter_Create_ContentPostLink extends GD_DataLoad_ActionExecuter_CreateUpdate_ContentPostLink
{
    public function getMutationResolverClass(): string
    {
        return GD_Create_PostLink::class;
    }
}
