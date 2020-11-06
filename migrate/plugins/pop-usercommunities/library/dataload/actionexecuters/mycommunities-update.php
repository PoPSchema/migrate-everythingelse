<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_Update_MyCommunities extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_Update_MyCommunities::class;
    }

    protected function returnIfError(): bool
    {
        // Allow for both success and errors (eg: some communities added, others not since they banned the user)
        return false;
    }
}

