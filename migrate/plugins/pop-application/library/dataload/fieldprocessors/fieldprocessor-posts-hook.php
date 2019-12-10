<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Media\Misc\MediaHelpers;
use PoP\PostMedia\Misc\MediaHelpers as PostMediaHelpers;
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

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
        $thumb_id = PostMediaHelpers::getThumbId($typeResolver->getId($post));
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
            'authors' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_ID),
            'topics' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
            'has-topics' => SchemaDefinition::TYPE_BOOL,
            'appliesto' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
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
                        SchemaDefinition::ARGNAME_DESCRIPTION => sprintf(
                            $translationAPI->__('Thumbnail size. By default it is \'%s\'', 'pop-posts'),
                            $this->getDefaultThumbSize()
                        ),
                    ],
                    [
                        SchemaDefinition::ARGNAME_NAME => 'addDescription',
                        SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_BOOL,
                        SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('Add description on the thumb', 'pop-posts'),
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
                $size = $fieldAtts['size'] ?? $this->getDefaultThumbSize();
                $add_description = isset($fieldAtts['addDescription']) ? $fieldAtts['addDescription'] : false;
                return $this->getThumb($post, $typeResolver, $size, $add_description);

            case 'thumb-full-src':
                $thumb = $typeResolver->resolveValue($post, FieldQueryInterpreterFacade::getInstance()->getField('thumb', ['size' => 'full', 'addDescription' => true]), $variables, $expressions, $options);
                return $thumb['src'];

            case 'authors':
                return gdGetPostauthors($typeResolver->getId($post));

            case 'topics':
                return \PoP\PostMeta\Utils::getPostMeta($typeResolver->getId($post), GD_METAKEY_POST_CATEGORIES);

            case 'has-topics':
                if ($typeResolver->resolveValue($post, 'topics', $variables, $expressions, $options)) {
                    return true;
                }
                return false;

            case 'appliesto':
                return \PoP\PostMeta\Utils::getPostMeta($typeResolver->getId($post), GD_METAKEY_POST_APPLIESTO);

            case 'has-appliesto':
                if ($typeResolver->resolveValue($post, 'appliesto', $variables, $expressions, $options)) {
                    return true;
                }
                return false;

            case 'has-userpostactivity':
                // User Post Activity: Comments + Responses/Additionals + Hightlights
                return
                    $typeResolver->resolveValue($resultItem, 'has-comments', $variables, $expressions, $options) ||
                    $typeResolver->resolveValue($resultItem, 'has-referencedby', $variables, $expressions, $options) ||
                    $typeResolver->resolveValue($resultItem, 'has-highlights', $variables, $expressions, $options);

            case 'userpostactivity-count':
                // User Post Activity: Comments + Responses/Additionals + Hightlights
                return
                    $typeResolver->resolveValue($resultItem, 'comments-count', $variables, $expressions, $options) +
                    $typeResolver->resolveValue($resultItem, 'referencedby-count', $variables, $expressions, $options) +
                    $typeResolver->resolveValue($resultItem, 'highlights-count', $variables, $expressions, $options);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldDefaultTypeDataResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'authors':
                return UserTypeDataResolver::class;
        }

        return parent::resolveFieldDefaultTypeDataResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}
    
// Static Initialization: Attach
PoP_Application_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
