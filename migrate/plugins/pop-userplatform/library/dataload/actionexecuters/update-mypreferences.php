<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_UpdateMyPreferences extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_UpdateMyPreferences::class;
    }
}

