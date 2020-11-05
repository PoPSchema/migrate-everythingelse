<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoPSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;

class GD_DataLoad_ActionExecuter_UndoDownvotePost implements \PoP\ComponentModel\ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_UndoDownvotePost();
    }

    public function execute(&$data_properties)
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
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        $gd_dataload_actionexecution_manager = \PoP\ComponentModel\ActionExecutionManagerFactory::getInstance();
        $gd_dataload_actionexecution_manager->setResult(get_called_class(), $target_id);
        $success_msg = sprintf(
            TranslationAPIFacade::getInstance()->__('You have stopped down-voting <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $customPostTypeAPI->getTitle($target_id)
        );

        // No errors => success
        return array(
            ResponseConstants::SUCCESSSTRINGS => array($success_msg),
            ResponseConstants::SUCCESS => true
        );
    }
}

