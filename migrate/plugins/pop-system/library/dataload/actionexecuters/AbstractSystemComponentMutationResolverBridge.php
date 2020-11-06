<?php

declare(strict_types=1);

use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

abstract class AbstractSystemComponentMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }
}

