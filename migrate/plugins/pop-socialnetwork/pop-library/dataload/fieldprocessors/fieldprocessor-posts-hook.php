<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Users\TypeDataResolvers\UserTypeDataResolver;

class GD_SocialNetwork_DataLoad_FieldResolver_Posts extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(PostTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'taggedusers',
            'recommendedby',
            'recommendpost-count',
            'upvotepost-count',
            'downvotepost-count',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'taggedusers' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_ID),
            'recommendedby' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_ID),
            'recommendpost-count' => SchemaDefinition::TYPE_INT,
            'upvotepost-count' => SchemaDefinition::TYPE_INT,
            'downvotepost-count' => SchemaDefinition::TYPE_INT,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'taggedusers' => $translationAPI->__('', ''),
            'recommendedby' => $translationAPI->__('', ''),
            'recommendpost-count' => $translationAPI->__('', ''),
            'upvotepost-count' => $translationAPI->__('', ''),
            'downvotepost-count' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmspostsapi = \PoP\Posts\FunctionAPIFactory::getInstance();
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $post = $resultItem;
        switch ($fieldName) {
            // Users mentioned in the post: @mentions
            case 'taggedusers':
                return \PoP\PostMeta\Utils::getPostMeta($typeResolver->getId($post), GD_METAKEY_POST_TAGGEDUSERS);

            case 'recommendedby':
                $query = [];
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsRecommendedby($query, $typeResolver->getId($post));
                return $cmsusersapi->getUsers($query, ['return-type' => POP_RETURNTYPE_IDS]);

            case 'recommendpost-count':
                return (int) \PoP\PostMeta\Utils::getPostMeta($typeResolver->getId($post), GD_METAKEY_POST_RECOMMENDCOUNT, true);

            case 'upvotepost-count':
                return (int) \PoP\PostMeta\Utils::getPostMeta($typeResolver->getId($post), GD_METAKEY_POST_UPVOTECOUNT, true);

            case 'downvotepost-count':
                return (int) \PoP\PostMeta\Utils::getPostMeta($typeResolver->getId($post), GD_METAKEY_POST_DOWNVOTECOUNT, true);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldDefaultTypeDataResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'taggedusers':
            case 'recommendedby':
                return UserTypeDataResolver::class;
        }

        return parent::resolveFieldDefaultTypeDataResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}
    
// Static Initialization: Attach
GD_SocialNetwork_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
