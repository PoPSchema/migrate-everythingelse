<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;

class GD_DataLoad_ActionExecuter_SystemActivatePlugins implements \PoP\ComponentModel\ActionExecuterInterface
{
    protected function getInstance()
    {
        return new GD_ActivatePlugins();
    }

    public function execute(&$data_properties)
    {
        $instance = $this->getInstance();
        $activated = $instance->activateplugins();
        $success_msg = $activated ? sprintf(
            TranslationAPIFacade::getInstance()->__('Successfully activated plugins: %s.', 'pop-system-wp'),
            implode(TranslationAPIFacade::getInstance()->__(', ', 'pop-system-wp'), $activated)
        ) : TranslationAPIFacade::getInstance()->__('There were no plugins to activate.', 'pop-system-wp');
        
        return array(
            ResponseConstants::SUCCESSSTRINGS => array($success_msg),
            ResponseConstants::SUCCESS => true
        );
    }
}
    
