<?php

use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\State\ApplicationState;

class GD_DataLoad_ActionExecuter_FileUploadPicture extends AbstractComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_FileUploadPicture::class;
    }
    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getFormData(): array
    {
        $vars = ApplicationState::getVars();
        return [
            'user_id' => $vars['global-userstate']['current-user-id'],
        ];
    }
    /**
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
    {
        parent::execute($data_properties);
        return null;
    }
}

