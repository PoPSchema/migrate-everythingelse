<?php
use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_Logout extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Logout::class;
    }

    public function getFormData(): array
    {
        return [];
    }
}

