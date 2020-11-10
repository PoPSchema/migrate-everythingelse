<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_SaveDefinitionFile extends AbstractMutationResolver
{
    public function execute(array $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('PoP:system:save-definition-file');
        return true;
    }
}
