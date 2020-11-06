<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;

abstract class GD_DataLoad_ActionExecuter_EmailInviteBase extends AbstractComponentMutationResolverBridge
{
    /**
     * @param mixed $result_id Maybe an int, maybe a string
     */
    public function getSuccessString($result_id): ?string
    {
        $emails = (array) $result_id;
        return sprintf(
            TranslationAPIFacade::getInstance()->__('Invitation sent to the following emails: <strong>%s</strong>'),
            implode(', ', $emails)
        );
    }

    protected function returnIfError(): bool
    {
        return false;
    }
}
