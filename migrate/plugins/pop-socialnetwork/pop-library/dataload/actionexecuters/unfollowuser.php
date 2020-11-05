<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;
use PoP\ComponentModel\Facades\MutationResolution\MutationResolutionManagerFacade;

class GD_DataLoad_ActionExecuter_UnfollowUser implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_UnfollowUser();
    }

    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
    {
        $errors = array();
        $instance = $this->getInstance();
        $target_id = $instance->execute($errors, $data_properties);

        if ($errors) {
            return array(
                ResponseConstants::ERRORSTRINGS => $errors
            );
        }

        // Save the result for some module to incorporate it into the query args
        $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
        $gd_dataload_actionexecution_manager = MutationResolutionManagerFacade::getInstance();
        $gd_dataload_actionexecution_manager->setResult(get_called_class(), $target_id);
        $success_msg = sprintf(
            TranslationAPIFacade::getInstance()->__('You have stopped following <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $cmsusersapi->getUserDisplayName($target_id)
        );

        // No errors => success
        return array(
            ResponseConstants::SUCCESSSTRINGS => array($success_msg),
            ResponseConstants::SUCCESS => true
        );
    }
}

