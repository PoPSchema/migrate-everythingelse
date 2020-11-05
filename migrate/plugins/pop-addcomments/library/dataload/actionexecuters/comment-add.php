<?php
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

class GD_DataLoad_ActionExecuter_AddComment implements ComponentMutationResolverBridgeInterface
{
    protected function getInstance()
    {
        return new GD_AddComment();
    }

    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
    {

        // If the post has been submitted, execute the Gravity Forms shortcode
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $errors = array();
            $instance = $this->getInstance();
            $comment_id = $instance->addcomment($errors, $data_properties);

            if ($errors) {
                return array(
                    ResponseConstants::ERRORSTRINGS => $errors
                );
            }

            // Save the result for some module to incorporate it into the query args
            $gd_dataload_actionexecution_manager = \PoP\ComponentModel\ActionExecutionManagerFactory::getInstance();
            $gd_dataload_actionexecution_manager->setResult(get_called_class(), $comment_id);

            // No errors => success
            return array(
                ResponseConstants::SUCCESS => true
            );
        }

        return null;
    }
}

