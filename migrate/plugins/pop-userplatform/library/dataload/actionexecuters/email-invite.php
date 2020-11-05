<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\ComponentMutationResolverBridgeInterface;

abstract class GD_DataLoad_ActionExecuter_EmailInviteBase implements ComponentMutationResolverBridgeInterface
{

    /**
     * Function to override
     */
    protected function getInstance()
    {
        return null;
    }

    public function execute(&$data_properties)
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $errors = array();
            $instance = $this->getInstance();
            $emails = $instance->execute($errors, $data_properties);

            // We can have both errors (invalid emails) and successes (invitation sent to valid emails)
            $ret = array();
            if ($errors) {
                $ret[ResponseConstants::ERRORSTRINGS] = $errors;
            }
            if ($emails) {
                $ret[ResponseConstants::SUCCESS] = true;
                $ret[ResponseConstants::SUCCESSSTRINGS] = array(
                    sprintf(
                        TranslationAPIFacade::getInstance()->__('Invitation sent to the following emails: <strong>%s</strong>'),
                        implode(', ', $emails)
                    )
                );
            }

            return $ret;
        }

        return null;
    }
}
