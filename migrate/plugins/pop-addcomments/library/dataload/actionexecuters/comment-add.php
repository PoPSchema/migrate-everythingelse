<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_AddComment extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_AddComment::class;
    }
}

