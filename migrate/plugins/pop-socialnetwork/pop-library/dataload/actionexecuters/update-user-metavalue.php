<?php
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

abstract class GD_DataLoad_ActionExecuter_UpdateUserMetaValue extends AbstractComponentMutationResolverBridge
{
    abstract protected function getRequestKey();

    public function getFormData(): array
    {
        $form_data = array(
            'target_id' => $_REQUEST[$this->getRequestKey()],
        );

        return $form_data;
    }
}

