<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_Login extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Login::class;
    }
}

