<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Posts\TypeResolvers\ContentEntityUnionTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\Posts\Facades\PostTypeAPIFacade;

class GD_SocialNetwork_DataLoad_FieldResolver_Users extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'recommendsposts',
            'followers',
            'following',
            'followers-count',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'recommendsposts' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
            'followers' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
            'following' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
            'followers-count' => SchemaDefinition::TYPE_INT,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'recommendsposts' => $translationAPI->__('', ''),
            'followers' => $translationAPI->__('', ''),
            'following' => $translationAPI->__('', ''),
            'followers-count' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        $user = $resultItem;
        switch ($fieldName) {
            case 'recommendsposts':
                $query = [];
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsAuthorrecommendedposts($query, $typeResolver->getID($user));
                return $postTypeAPI->getPosts($query, ['return-type' => POP_RETURNTYPE_IDS]);

            case 'followers':
                $query = [];
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsAuthorfollowers($query, $typeResolver->getID($user));
                return $cmsusersapi->getUsers($query, ['return-type' => POP_RETURNTYPE_IDS]);

            case 'following':
                $query = [];
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsAuthorfollowingusers($query, $typeResolver->getID($user));
                return $cmsusersapi->getUsers($query, ['return-type' => POP_RETURNTYPE_IDS]);

            case 'followers-count':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_FOLLOWERSCOUNT, true);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldTypeResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'recommendsposts':
                return ContentEntityUnionTypeResolver::class;

            case 'followers':
            case 'following':
                return UserTypeResolver::class;
        }

        return parent::resolveFieldTypeResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}

// Static Initialization: Attach
GD_SocialNetwork_DataLoad_FieldResolver_Users::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
