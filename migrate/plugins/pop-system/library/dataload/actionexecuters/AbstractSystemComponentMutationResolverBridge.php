<?php

declare(strict_types=1);

use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;

abstract class AbstractSystemComponentMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getFormData(): array
    {
        return [];
    }
}

