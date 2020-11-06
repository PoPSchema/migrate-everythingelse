<?php
use PoP\Translation\Facades\TranslationAPIFacade;

class GD_DataLoad_ActionExecuter_UnfollowUser extends GD_DataLoad_ActionExecuter_UpdateUserMetaValue_User
{
    public function getMutationResolverClass(): string
    {
        return GD_UnfollowUser::class;
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    /**
     * @param mixed $result_id Maybe an int, maybe a string
     */
    public function getSuccessString($result_id): ?string
    {
        $cmsusersapi = \PoPSchema\Users\FunctionAPIFactory::getInstance();
        return sprintf(
            TranslationAPIFacade::getInstance()->__('You have stopped following <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $cmsusersapi->getUserDisplayName($result_id)
        );
    }
}

