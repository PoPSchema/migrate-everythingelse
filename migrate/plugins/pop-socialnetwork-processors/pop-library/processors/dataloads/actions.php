<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\ModuleProcessors\DataloadingConstants;
use PoP\Engine\ModuleProcessors\DBObjectIDFromURLParamModuleProcessorTrait;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\Taxonomies\TypeResolvers\TagTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;

class PoP_Module_Processor_ActionDataloads extends PoP_Module_Processor_DataloadsBase
{
    use DBObjectIDFromURLParamModuleProcessorTrait;

    public const MODULE_DATALOADACTION_FOLLOWUSER = 'dataloadaction-followuser';
    public const MODULE_DATALOADACTION_UNFOLLOWUSER = 'dataloadaction-unfollowuser';
    public const MODULE_DATALOADACTION_RECOMMENDPOST = 'dataloadaction-recommendpost';
    public const MODULE_DATALOADACTION_UNRECOMMENDPOST = 'dataloadaction-unrecommendpost';
    public const MODULE_DATALOADACTION_SUBSCRIBETOTAG = 'dataloadaction-subscribetotag';
    public const MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG = 'dataloadaction-unsubscribefromtag';
    public const MODULE_DATALOADACTION_UPVOTEPOST = 'dataloadaction-upvotepost';
    public const MODULE_DATALOADACTION_UNDOUPVOTEPOST = 'dataloadaction-undoupvotepost';
    public const MODULE_DATALOADACTION_DOWNVOTEPOST = 'dataloadaction-downvotepost';
    public const MODULE_DATALOADACTION_UNDODOWNVOTEPOST = 'dataloadaction-undodownvotepost';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOADACTION_FOLLOWUSER],
            [self::class, self::MODULE_DATALOADACTION_UNFOLLOWUSER],
            [self::class, self::MODULE_DATALOADACTION_RECOMMENDPOST],
            [self::class, self::MODULE_DATALOADACTION_UNRECOMMENDPOST],
            [self::class, self::MODULE_DATALOADACTION_SUBSCRIBETOTAG],
            [self::class, self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG],
            [self::class, self::MODULE_DATALOADACTION_UPVOTEPOST],
            [self::class, self::MODULE_DATALOADACTION_UNDOUPVOTEPOST],
            [self::class, self::MODULE_DATALOADACTION_DOWNVOTEPOST],
            [self::class, self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST],
        );
    }

    public function getRelevantRoute(array $module, array &$props): ?string
    {
        $routes = array(
            self::MODULE_DATALOADACTION_DOWNVOTEPOST => POP_SOCIALNETWORK_ROUTE_DOWNVOTEPOST,
            self::MODULE_DATALOADACTION_FOLLOWUSER => POP_SOCIALNETWORK_ROUTE_FOLLOWUSER,
            self::MODULE_DATALOADACTION_RECOMMENDPOST => POP_SOCIALNETWORK_ROUTE_RECOMMENDPOST,
            self::MODULE_DATALOADACTION_SUBSCRIBETOTAG => POP_SOCIALNETWORK_ROUTE_SUBSCRIBETOTAG,
            self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST => POP_SOCIALNETWORK_ROUTE_UNDODOWNVOTEPOST,
            self::MODULE_DATALOADACTION_UNDOUPVOTEPOST => POP_SOCIALNETWORK_ROUTE_UNDOUPVOTEPOST,
            self::MODULE_DATALOADACTION_UNFOLLOWUSER => POP_SOCIALNETWORK_ROUTE_UNFOLLOWUSER,
            self::MODULE_DATALOADACTION_UNRECOMMENDPOST => POP_SOCIALNETWORK_ROUTE_UNRECOMMENDPOST,
            self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG => POP_SOCIALNETWORK_ROUTE_UNSUBSCRIBEFROMTAG,
            self::MODULE_DATALOADACTION_UPVOTEPOST => POP_SOCIALNETWORK_ROUTE_UPVOTEPOST,
        );
        return $routes[$module[1]] ?? parent::getRelevantRoute($module, $props);
    }

    public function getActionexecuterClass(array $module): ?string
    {
        $executers = array(
            self::MODULE_DATALOADACTION_FOLLOWUSER => GD_DataLoad_ActionExecuter_FollowUser::class,
            self::MODULE_DATALOADACTION_UNFOLLOWUSER => GD_DataLoad_ActionExecuter_UnfollowUser::class,
            self::MODULE_DATALOADACTION_RECOMMENDPOST => GD_DataLoad_ActionExecuter_RecommendPost::class,
            self::MODULE_DATALOADACTION_UNRECOMMENDPOST => GD_DataLoad_ActionExecuter_UnrecommendPost::class,
            self::MODULE_DATALOADACTION_SUBSCRIBETOTAG => GD_DataLoad_ActionExecuter_SubscribeToTag::class,
            self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG => GD_DataLoad_ActionExecuter_UnsubscribeFromTag::class,
            self::MODULE_DATALOADACTION_UPVOTEPOST => GD_DataLoad_ActionExecuter_UpvotePost::class,
            self::MODULE_DATALOADACTION_UNDOUPVOTEPOST => GD_DataLoad_ActionExecuter_UndoUpvotePost::class,
            self::MODULE_DATALOADACTION_DOWNVOTEPOST => GD_DataLoad_ActionExecuter_DownvotePost::class,
            self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST => GD_DataLoad_ActionExecuter_UndoDownvotePost::class,
        );
        if ($executer = $executers[$module[1]]) {
            return $executer;
        }

        return parent::getActionexecuterClass($module);
    }

    // function getActionexecutionCheckpointConfiguration(array $module, array &$props) {
        
    //     // The actionexecution is triggered when clicking on the link, not when submitting a form
    //     switch ($module[1]) {
                    
    //         case self::MODULE_DATALOADACTION_FOLLOWUSER:
    //         case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
    //         case self::MODULE_DATALOADACTION_RECOMMENDPOST:
    //         case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
    //         case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
    //         case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
    //         case self::MODULE_DATALOADACTION_UPVOTEPOST:
    //         case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
    //         case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
    //         case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:

    //             return null;
    //     }

    //     return parent::getActionexecutionCheckpointConfiguration($module, $props);
    // }

    public function executeAction(array $module, array &$props)
    {
        // The actionexecution is triggered when clicking on the link, not when submitting a form
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_FOLLOWUSER:
            case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
            case self::MODULE_DATALOADACTION_RECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
            case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
            case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
            case self::MODULE_DATALOADACTION_UPVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
            case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:
                return true;
        }

        return parent::executeAction($module, $props);
    }

    protected function getCheckpointmessageModule(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_FOLLOWUSER:
            case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
            case self::MODULE_DATALOADACTION_RECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
            case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
            case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
            case self::MODULE_DATALOADACTION_UPVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
            case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:
                return [GD_UserLogin_Module_Processor_UserCheckpointMessages::class, GD_UserLogin_Module_Processor_UserCheckpointMessages::MODULE_CHECKPOINTMESSAGE_LOGGEDIN];
        }

        return parent::getCheckpointmessageModule($module);
    }

    protected function getFeedbackmessageModule(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_FOLLOWUSER:
            case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
            case self::MODULE_DATALOADACTION_RECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
            case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
            case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
            case self::MODULE_DATALOADACTION_UPVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
            case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:
                return [PoP_Module_Processor_DomainFeedbackMessages::class, PoP_Module_Processor_DomainFeedbackMessages::MODULE_FEEDBACKMESSAGE_EMPTY];
        }

        return parent::getFeedbackmessageModule($module);
    }

    public function prepareDataPropertiesAfterActionexecution(array $module, array &$props, &$data_properties)
    {
        parent::prepareDataPropertiesAfterActionexecution($module, $props, $data_properties);

        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_FOLLOWUSER:
            case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
            case self::MODULE_DATALOADACTION_RECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
            case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
            case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
            case self::MODULE_DATALOADACTION_UPVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
            case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:
                $gd_dataload_actionexecution_manager = \PoP\ComponentModel\ActionExecutionManagerFactory::getInstance();
                if ($target_id = $gd_dataload_actionexecution_manager->getResult($this->getActionexecuterClass($module))) {
                    $data_properties[DataloadingConstants::QUERYARGS]['include'] = array($target_id);
                } else {
                    $data_properties[DataloadingConstants::SKIPDATALOAD] = true;
                }
                break;
        }
    }

    protected function getInnerSubmodules(array $module): array
    {
        $ret = parent::getInnerSubmodules($module);

        $layouts = array(
            self::MODULE_DATALOADACTION_FOLLOWUSER => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_FOLLOWSUSERS],
            self::MODULE_DATALOADACTION_UNFOLLOWUSER => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_UNFOLLOWSUSERS],
            self::MODULE_DATALOADACTION_RECOMMENDPOST => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_RECOMMENDSPOSTS],
            self::MODULE_DATALOADACTION_UNRECOMMENDPOST => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_UNRECOMMENDSPOSTS],
            self::MODULE_DATALOADACTION_SUBSCRIBETOTAG => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_SUBSCRIBESTOTAGS],
            self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_UNSUBSCRIBESFROMTAGS],
            self::MODULE_DATALOADACTION_UPVOTEPOST => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_UPVOTESPOSTS],
            self::MODULE_DATALOADACTION_UNDOUPVOTEPOST => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_UNDOUPVOTESPOSTS],
            self::MODULE_DATALOADACTION_DOWNVOTEPOST => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_DOWNVOTESPOSTS],
            self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST => [PoP_Module_Processor_FunctionsContents::class, PoP_Module_Processor_FunctionsContents::MODULE_CONTENT_UNDODOWNVOTESPOSTS],
        );
        if ($layout = $layouts[$module[1]]) {
            $ret[] = $layout;
        }
    
        return $ret;
    }

    public function getDBObjectIDOrIDs(array $module, array &$props, &$data_properties)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_RECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UPVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
            case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
            case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
            case self::MODULE_DATALOADACTION_FOLLOWUSER:
            case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
                return $this->getDBObjectIDFromURLParam($module, $props, $data_properties);
        }
        return parent::getDBObjectIDOrIDs($module, $props, $data_properties);
    }

    protected function getDBObjectIDParamName(array $module, array &$props, &$data_properties)
    {
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_RECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UPVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
            case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:
                return POP_INPUTNAME_POSTID;
            case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
            case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
                return POP_INPUTNAME_TAGID;
            case self::MODULE_DATALOADACTION_FOLLOWUSER:
            case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
                return POP_INPUTNAME_USERID;
        }
        return null;
    }

    public function getTypeResolverClass(array $module): ?string
    {
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_FOLLOWUSER:
            case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
                return UserTypeResolver::class;

            case self::MODULE_DATALOADACTION_RECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UPVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
            case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:
                return PostTypeResolver::class;

            case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
            case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
                return TagTypeResolver::class;
        }
        
        return parent::getTypeResolverClass($module);
    }
    
    public function initModelProps(array $module, array &$props)
    {
        $towhats = array(
            self::MODULE_DATALOADACTION_FOLLOWUSER => TranslationAPIFacade::getInstance()->__('follow users', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_UNFOLLOWUSER => TranslationAPIFacade::getInstance()->__('stop following users', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_RECOMMENDPOST => TranslationAPIFacade::getInstance()->__('recommend posts', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_UNRECOMMENDPOST => TranslationAPIFacade::getInstance()->__('stop recommending posts', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_SUBSCRIBETOTAG => TranslationAPIFacade::getInstance()->__('subscribe to tags/topics', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG => TranslationAPIFacade::getInstance()->__('unsubscribe from tags/topics', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_UPVOTEPOST => TranslationAPIFacade::getInstance()->__('up-vote posts', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_UNDOUPVOTEPOST => TranslationAPIFacade::getInstance()->__('stop up-voting posts', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_DOWNVOTEPOST => TranslationAPIFacade::getInstance()->__('down-vote posts', 'pop-coreprocessors'),
            self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST => TranslationAPIFacade::getInstance()->__('stop down-voting posts', 'pop-coreprocessors'),
        );
        if ($towhat = $towhats[$module[1]]) {
            $this->setProp([GD_UserLogin_Module_Processor_UserCheckpointMessageLayouts::class, GD_UserLogin_Module_Processor_UserCheckpointMessageLayouts::MODULE_LAYOUT_CHECKPOINTMESSAGE_LOGGEDIN], $props, 'action', $towhat);
        }

        // Remove the success/error headers
        $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::MODULE_LAYOUT_FEEDBACKMESSAGE_EMPTY], $props, 'error-header', '');
        $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::MODULE_LAYOUT_FEEDBACKMESSAGE_EMPTY], $props, 'success-header', '');
    
        switch ($module[1]) {
            case self::MODULE_DATALOADACTION_FOLLOWUSER:
            case self::MODULE_DATALOADACTION_UNFOLLOWUSER:
            case self::MODULE_DATALOADACTION_RECOMMENDPOST:
            case self::MODULE_DATALOADACTION_UNRECOMMENDPOST:
            case self::MODULE_DATALOADACTION_SUBSCRIBETOTAG:
            case self::MODULE_DATALOADACTION_UNSUBSCRIBEFROMTAG:
            case self::MODULE_DATALOADACTION_UPVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDOUPVOTEPOST:
            case self::MODULE_DATALOADACTION_DOWNVOTEPOST:
            case self::MODULE_DATALOADACTION_UNDODOWNVOTEPOST:
                $this->appendProp($module, $props, 'class', 'hidden');
                break;
        }
        
        parent::initModelProps($module, $props);
    }
}



