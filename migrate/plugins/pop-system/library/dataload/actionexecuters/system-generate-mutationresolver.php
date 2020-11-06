<?php
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_SystemGenerate implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes)
    {
        HooksAPIFacade::getInstance()->doAction('PoP:system-generate');
    }
}
