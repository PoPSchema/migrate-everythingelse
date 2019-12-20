<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Comments\TypeResolvers\CommentTypeResolver;
use PoP\Notifications\TypeResolvers\NotificationTypeResolver;
use PoP\Posts\Facades\PostTypeAPIFacade;

class PoP_AddComments_DataLoad_FieldResolver_Notifications extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(NotificationTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'comment-object-id',
            'icon',
            'url',
            'message',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'comment-object-id' => SchemaDefinition::TYPE_ID,
            'icon' => SchemaDefinition::TYPE_STRING,
            'url' => SchemaDefinition::TYPE_URL,
            'message' => SchemaDefinition::TYPE_STRING,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'comment-object-id' => $translationAPI->__('', ''),
            'icon' => $translationAPI->__('', ''),
            'url' => $translationAPI->__('', ''),
            'message' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveCanProcessResultItem(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): bool
    {
        $notification = $resultItem;
        return $notification->object_type == 'Comments' && in_array(
            $notification->action,
            [
                AAL_POP_ACTION_COMMENT_ADDED,
                AAL_POP_ACTION_COMMENT_SPAMMEDCOMMENT,
            ]
        );
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $cmscommentsapi = \PoP\Comments\FunctionAPIFactory::getInstance();
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        // $cmspagesapi = \PoP\Pages\FunctionAPIFactory::getInstance();
        $cmspostsapi = PostTypeAPIFacade::getInstance();
        $cmscommentsresolver = \PoP\Comments\ObjectPropertyResolverFactory::getInstance();
        $notification = $resultItem;
        switch ($fieldName) {
            // Specific fields to be used by the subcomponents, based on a combination of Object Type + Action
            // Needed to, for instance, load the comment immediately, already from the notification
            case 'comment-object-id':
                switch ($notification->action) {
                    case AAL_POP_ACTION_COMMENT_ADDED:
                        // comment-object-id is the object-id
                        return $typeResolver->resolveValue($resultItem, FieldQueryInterpreterFacade::getInstance()->getField('object-id', $fieldArgs), $variables, $expressions, $options);
                }
                return null;

            case 'icon':
                // URL depends basically on the action performed on the object type
                switch ($notification->action) {
                    case AAL_POP_ACTION_COMMENT_SPAMMEDCOMMENT:
                        $icons = array(
                            AAL_POP_ACTION_COMMENT_SPAMMEDCOMMENT => 'fa-trash',
                        );
                        return $icons[$notification->action];

                    case AAL_POP_ACTION_COMMENT_ADDED:
                        $routes = array(
                            AAL_POP_ACTION_COMMENT_ADDED => POP_ADDCOMMENTS_ROUTE_ADDCOMMENT,
                        );
                        return getRouteIcon($routes[$notification->action], false);
                }
                return null;

            case 'url':
                // URL depends basically on the action performed on the object type
                switch ($notification->action) {
                    case AAL_POP_ACTION_COMMENT_SPAMMEDCOMMENT:
                        // $pages = array(
                        //     AAL_POP_ACTION_COMMENT_SPAMMEDCOMMENT => POP_ADDCOMMENTS_PAGEPLACEHOLDER_SPAMMEDCOMMENTNOTIFICATION,
                        // );
                        // return $cmspagesapi->getPageURL($pages[$notification->action]);
                        return POP_ADDCOMMENTS_URLPLACEHOLDER_SPAMMEDCOMMENTNOTIFICATION;
                }
                return null;

            case 'message':
                // Message depends basically on the action performed on the object type
                switch ($notification->action) {
                    case AAL_POP_ACTION_COMMENT_SPAMMEDCOMMENT:
                        $comment = $cmscommentsapi->getComment($notification->object_id);
                        $messages = array(
                            AAL_POP_ACTION_COMMENT_SPAMMEDCOMMENT => TranslationAPIFacade::getInstance()->__('Your comment on %1$s <strong>%2$s</strong> was deleted for not adhering to our content guidelines', 'pop-notifications'),
                        );
                        return sprintf(
                            $messages[$notification->action],
                            gdGetPostname($cmscommentsresolver->getCommentPostId($comment), 'lc'),
                            $cmspostsapi->getTitle($cmscommentsresolver->getCommentPostId($comment))
                        );

                    case AAL_POP_ACTION_COMMENT_ADDED:
                        // TODO: Integrate with `mustHaveUserAccountToAddComment`
                        $comment = $cmscommentsapi->getComment($notification->object_id);
                        $user_id = $vars['global-userstate']['current-user-id'];

                        // Change the message if the comment is a response to the user's comment
                        $message = TranslationAPIFacade::getInstance()->__('<strong>%1$s</strong> commented in %2$s <strong>%3$s</strong>', 'pop-notifications');
                        if ($comment_parent_id = $cmscommentsresolver->getCommentParent($comment)) {
                            $comment_parent = $cmscommentsapi->getComment($comment_parent_id);
                            if ($cmscommentsresolver->getCommentUserId($comment_parent) == $user_id) {
                                $message = TranslationAPIFacade::getInstance()->__('<strong>%1$s</strong> replied to your comment in %2$s <strong>%3$s</strong>', 'pop-notifications');
                            }
                        }

                        // Allow PoP Social Network to make the message more precise
                        $message = HooksAPIFacade::getInstance()->applyFilters(
                            'PoP_AddComments_DataLoad_TypeResolver_Notifications_Hook:comment-added:message',
                            $message,
                            $notification
                        );

                        return sprintf(
                            $message,
                            $cmsusersapi->getUserDisplayName($notification->user_id),
                            gdGetPostname($cmscommentsresolver->getCommentPostId($comment), 'lc'),
                            $cmspostsapi->getTitle($cmscommentsresolver->getCommentPostId($comment))
                        );
                }
                return null;
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldTypeResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'comment-object-id':
                return CommentTypeResolver::class;
        }

        return parent::resolveFieldTypeResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}
    
// Static Initialization: Attach
PoP_AddComments_DataLoad_FieldResolver_Notifications::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS, 20);
