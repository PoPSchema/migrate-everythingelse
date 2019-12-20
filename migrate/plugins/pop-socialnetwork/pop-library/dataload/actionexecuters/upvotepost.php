<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\Posts\Facades\PostTypeAPIFacade;

class GD_DataLoad_ActionExecuter_UpvotePost implements \PoP\ComponentModel\ActionExecuterInterface
{
    protected function getInstance()
    {
        return new GD_UpvotePost();
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
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $gd_dataload_actionexecution_manager = \PoP\ComponentModel\ActionExecutionManagerFactory::getInstance();
        $gd_dataload_actionexecution_manager->setResult(self::class, $target_id);
        $success_msg = sprintf(
            TranslationAPIFacade::getInstance()->__('You have up-voted <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $cmspostsapi->getTitle($target_id)
        );

        // No errors => success
        return array(
            ResponseConstants::SUCCESSSTRINGS => array($success_msg),
            ResponseConstants::SUCCESS => true
        );
    }
}
    
