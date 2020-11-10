<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_SystemGenerate extends AbstractMutationResolver
{
    public function execute(array $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('PoP:system-generate');
        return true;
    }
}
