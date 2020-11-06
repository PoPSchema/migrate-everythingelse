<?php

use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

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

