<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\QueryInputOutputHandlers\ResponseConstants;
use PoP\ComponentModel\MutationResolvers\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\Facades\MutationResolution\MutationResolutionManagerFacade;

class GD_DataLoad_ActionExecuter_SubscribeToTag extends AbstractComponentMutationResolverBridge
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
     * @param array $data_properties
     * @return array<string, mixed>|null
     */
    public function execute(array &$data_properties): ?array
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
        $posttagapi = \PoPSchema\PostTags\FunctionAPIFactory::getInstance();
        $applicationtaxonomyapi = \PoP\ApplicationTaxonomies\FunctionAPIFactory::getInstance();
        $gd_dataload_actionexecution_manager = MutationResolutionManagerFacade::getInstance();
        $gd_dataload_actionexecution_manager->setResult(get_called_class(), $target_id);
        $tag = $posttagapi->getTag($target_id);
        $success_msg = sprintf(
            TranslationAPIFacade::getInstance()->__('You have subscribed to <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $applicationtaxonomyapi->getTagSymbolName($tag)
        );

        // No errors => success
        return array(
            ResponseConstants::SUCCESSSTRINGS => array($success_msg),
            ResponseConstants::SUCCESS => true
        );
    }
}

