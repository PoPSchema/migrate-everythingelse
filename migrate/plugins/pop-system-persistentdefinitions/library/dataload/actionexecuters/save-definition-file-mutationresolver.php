<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_SaveDefinitionFile extends AbstractMutationResolver
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('PoP:system:save-definition-file');
    }
}
