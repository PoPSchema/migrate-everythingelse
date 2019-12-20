<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Media\Misc\MediaHelpers;
use PoP\PostMedia\Misc\MediaHelpers as PostMediaHelpers;
use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\ComponentModel\GeneralUtils;

class PoP_Application_DataLoad_FieldResolver_Posts extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            PostTypeResolver::class,
        );
    }

    public function getThumb($post, TypeResolverInterface $typeResolver, $size = null, $add_description = false)
    {
        $thumb_id = PostMediaHelpers::getThumbId($typeResolver->getID($post));
        $img = MediaHelpers::getAttachmentImageProperties($thumb_id, $size);

        // Add the image description
        if ($add_description && $img) {
            $cmsmediaapi = \PoP\Media\FunctionAPIFactory::getInstance();
            if ($description = $cmsmediaapi->getMediaDescription($thumb_id)) {
                $img['description'] = $description;
            }
        }

        return $img;
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'favicon',
            'thumb',
            'thumb-full-src',
            'authors',
            'topics',
            'has-topics',
            'appliesto',
            'has-appliesto',
            'has-userpostactivity',
            'userpostactivity-count',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'favicon' => SchemaDefinition::TYPE_OBJECT,
            'thumb' => SchemaDefinition::TYPE_OBJECT,
            'thumb-full-src' => SchemaDefinition::TYPE_URL,
            'authors' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
            'topics' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
            'has-topics' => SchemaDefinition::TYPE_BOOL,
            'appliesto' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
            'has-appliesto' => SchemaDefinition::TYPE_BOOL,
            'has-userpostactivity' => SchemaDefinition::TYPE_BOOL,
            'userpostactivity-count' => SchemaDefinition::TYPE_INT,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'favicon' => $translationAPI->__('', ''),
            'thumb' => $translationAPI->__('', ''),
            'thumb-full-src' => $translationAPI->__('', ''),
            'authors' => $translationAPI->__('', ''),
            'topics' => $translationAPI->__('', ''),
            'has-topics' => $translationAPI->__('', ''),
            'appliesto' => $translationAPI->__('', ''),
            'has-appliesto' => $translationAPI->__('', ''),
            'has-userpostactivity' => $translationAPI->__('', ''),
            'userpostactivity-count' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function getSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        switch ($fieldName) {
            case 'favicon':
            case 'thumb':
                return [
                    [
                        SchemaDefinition::ARGNAME_NAME => 'size',
                        SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_STRING,
                        SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('Thumbnail size', 'pop-posts'),
                        SchemaDefinition::ARGNAME_DEFAULT_VALUE => $this->getDefaultThumbSize(),
                    ],
                    [
                        SchemaDefinition::ARGNAME_NAME => 'addDescription',
                        SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_BOOL,
                        SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('Add description on the thumb', 'pop-posts'),
                        SchemaDefinition::ARGNAME_DEFAULT_VALUE => 'false',
                    ],
                ];
        }

        return parent::getSchemaFieldArgs($typeResolver, $fieldName);
    }

    protected function getDefaultThumbSize(): string
    {
        return 'thumb-md';
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $post = $resultItem;
        switch ($fieldName) {
            case 'favicon':
            case 'thumb':
                $size = $fieldArgs['size'] ?? $this->getDefaultThumbSize();
                $add_description = isset($fieldArgs['addDescription']) ? $fieldArgs['addDescription'] : false;
                return $this->getThumb($post, $typeResolver, $size, $add_description);

            case 'thumb-full-src':
                $thumb = $typeResolver->resolveValue($post, FieldQueryInterpreterFacade::getInstance()->getField('thumb', ['size' => 'full', 'addDescription' => true]), $variables, $expressions, $options);
                if (GeneralUtils::isError($thumb)) {
                    return $thumb;
                }
                return $thumb['src'];

            case 'authors':
                return gdGetPostauthors($typeResolver->getID($post));

            case 'topics':
                return \PoP\PostMeta\Utils::getPostMeta($typeResolver->getID($post), GD_METAKEY_POST_CATEGORIES);

            case 'has-topics':
                $topics = $typeResolver->resolveValue($post, 'topics', $variables, $expressions, $options);
                if (GeneralUtils::isError($topics)) {
                    return $topics;
                } elseif ($topics) {
                    return true;
                }
                return false;

            case 'appliesto':
                return \PoP\PostMeta\Utils::getPostMeta($typeResolver->getID($post), GD_METAKEY_POST_APPLIESTO);

            case 'has-appliesto':
                $appliesto = $typeResolver->resolveValue($post, 'appliesto', $variables, $expressions, $options);
                if (GeneralUtils::isError($appliesto)) {
                    return $appliesto;
                } elseif ($appliesto) {
                    return true;
                }
                return false;

            case 'has-userpostactivity':
                // User Post Activity: Comments + Responses/Additionals + Hightlights
                $hasComments = $typeResolver->resolveValue($resultItem, 'has-comments', $variables, $expressions, $options);
                if ($hasComments) {
                    return $hasComments;
                }
                $hasReferencedBy = $typeResolver->resolveValue($resultItem, 'has-referencedby', $variables, $expressions, $options);
                if ($hasReferencedBy) {
                    return $hasReferencedBy;
                }
                $hasHighlights = $typeResolver->resolveValue($resultItem, 'has-highlights', $variables, $expressions, $options);
                if ($hasHighlights) {
                    return $hasHighlights;
                }
                return $hasComments || $hasReferencedBy || $hasHighlights;

            case 'userpostactivity-count':
                // User Post Activity: Comments + Responses/Additionals + Hightlights
                $commentsCount = $typeResolver->resolveValue($resultItem, 'comments-count', $variables, $expressions, $options);
                if ($commentsCount) {
                    return $commentsCount;
                }
                $referencedByCount = $typeResolver->resolveValue($resultItem, 'referencedby-count', $variables, $expressions, $options);
                if ($referencedByCount) {
                    return $referencedByCount;
                }
                $highlightsCount = $typeResolver->resolveValue($resultItem, 'highlights-count', $variables, $expressions, $options);
                if ($highlightsCount) {
                    return $highlightsCount;
                }
                return $commentsCount + $referencedByCount + $highlightsCount;
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldTypeResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'authors':
                return UserTypeResolver::class;
        }

        return parent::resolveFieldTypeResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}

// Static Initialization: Attach
PoP_Application_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
