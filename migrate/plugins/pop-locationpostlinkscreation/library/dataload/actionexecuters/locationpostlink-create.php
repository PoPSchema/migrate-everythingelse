<?php
use PoPSchema\PostMutations\MutationResolvers\AbstractCreateUpdatePostMutationResolverBridge;

class GD_DataLoad_ActionExecuter_Create_LocationPostLink extends AbstractCreateUpdatePostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_CreateLocationPostLink::class;
    }
}

