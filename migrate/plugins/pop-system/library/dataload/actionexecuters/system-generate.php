<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_SystemGenerate implements \PoP\ComponentModel\ActionExecuterInterface
{
    public function execute(&$data_properties)
    {
        HooksAPIFacade::getInstance()->doAction('PoP:system-generate');

        $success_msg = TranslationAPIFacade::getInstance()->__('System action "generate" executed successfully.', 'pop-system');
        return array(
            ResponseConstants::SUCCESSSTRINGS => array($success_msg),
            ResponseConstants::SUCCESS => true
        );
    }
}
    
