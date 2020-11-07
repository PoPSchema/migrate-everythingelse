<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\Hooks\Facades\HooksAPIFacade;

class GD_SystemGenerateTheme extends AbstractMutationResolver
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        HooksAPIFacade::getInstance()->doAction('PoP:system-generate:theme');
    }
}
