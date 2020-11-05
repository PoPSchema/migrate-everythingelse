<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\Info\ApplicationInfoFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_SystemInstall implements ComponentMutationResolverBridgeInterface
{
    public function execute(&$data_properties)
    {
        // Save the new version on the DB
        update_option('PoP:version', ApplicationInfoFacade::getInstance()->getVersion());

        // Execute install everywhere
        HooksAPIFacade::getInstance()->doAction('PoP:system-install');

        $success_msg = TranslationAPIFacade::getInstance()->__('System action "install" executed successfully.', 'pop-system');
        return array(
            ResponseConstants::SUCCESSSTRINGS => array($success_msg),
            ResponseConstants::SUCCESS => true
        );
    }
}

