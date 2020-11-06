<?php
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\Info\ApplicationInfoFacade;

class GD_SystemInstall implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes)
    {
        // Save the new version on the DB
        update_option('PoP:version', ApplicationInfoFacade::getInstance()->getVersion());

        // Execute install everywhere
        HooksAPIFacade::getInstance()->doAction('PoP:system-install');
    }
}
