<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoPSitesWassup\SystemMutations\MutationResolverBridges\AbstractSystemComponentMutationResolverBridge;

class GD_DataLoad_ActionExecuter_SystemGenerateTheme extends AbstractSystemComponentMutationResolverBridge
{
    public function getMutationResolverClass(): string
    {
        return GD_SystemGenerateTheme::class;
    }
    /**
     * @param mixed $result_id Maybe an int, maybe a string
     */
    public function getSuccessString($result_id): ?string
    {
        return TranslationAPIFacade::getInstance()->__('System action "generate theme" executed successfully.', 'pop-system');
    }
}

