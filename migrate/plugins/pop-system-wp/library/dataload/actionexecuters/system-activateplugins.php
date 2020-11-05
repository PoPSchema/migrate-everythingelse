<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_SystemActivatePlugins implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_ActivatePlugins();
    }

    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
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

