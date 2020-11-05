<?php
use PoPSchema\PostMutations\MutationResolvers\AbstractCreateUpdatePostMutationResolverBridge;

class GD_DataLoad_ActionExecuter_CreateUpdate_LocationPost extends AbstractCreateUpdatePostMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_CreateUpdate_LocationPost::class;
    }
}

