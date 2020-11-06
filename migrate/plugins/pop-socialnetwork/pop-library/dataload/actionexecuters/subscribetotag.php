<?php
use PoP\Translation\Facades\TranslationAPIFacade;

class GD_DataLoad_ActionExecuter_SubscribeToTag extends GD_DataLoad_ActionExecuter_UpdateUserMetaValue_Tag
{
    public function getMutationResolverClass(): string
    {
        return GD_SubscribeToTag::class;
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
        $applicationtaxonomyapi = \PoP\ApplicationTaxonomies\FunctionAPIFactory::getInstance();
        $posttagapi = \PoPSchema\PostTags\FunctionAPIFactory::getInstance();
        $tag = $posttagapi->getTag($result_id);
        return sprintf(
            TranslationAPIFacade::getInstance()->__('You have subscribed to <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $applicationtaxonomyapi->getTagSymbolName($tag)
        );
    }
}

