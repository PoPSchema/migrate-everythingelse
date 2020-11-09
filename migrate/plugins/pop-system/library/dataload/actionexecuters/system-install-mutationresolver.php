<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\Info\ApplicationInfoFacade;

class GD_SystemInstall extends AbstractMutationResolver
{
    public function execute(array $form_data)
    {
        // Save the new version on the DB
        update_option('PoP:version', ApplicationInfoFacade::getInstance()->getVersion());

        // Execute install everywhere
        HooksAPIFacade::getInstance()->doAction('PoP:system-install');
    }
}