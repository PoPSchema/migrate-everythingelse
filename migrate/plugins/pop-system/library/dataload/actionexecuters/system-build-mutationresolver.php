<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_SystemBuild extends AbstractMutationResolver
{
    public function execute(array $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('PoP:system-build');
        return true;
    }
}
