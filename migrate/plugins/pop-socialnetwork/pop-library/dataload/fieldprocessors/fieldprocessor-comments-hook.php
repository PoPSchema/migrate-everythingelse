<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Comments\TypeResolvers\CommentTypeResolver;
use PoP\Users\TypeResolvers\UserTypeResolver;

class GD_DataLoad_FieldResolver_Comments extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(CommentTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'taggedusers',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'taggedusers' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_ID),
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'taggedusers' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $comment = $resultItem;

        switch ($fieldName) {
            // Users mentioned in the comment: @mentions
            case 'taggedusers':
                return \PoP\CommentMeta\Utils::getCommentMeta($typeResolver->getId($comment), GD_METAKEY_COMMENT_TAGGEDUSERS);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldTypeResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'taggedusers':
                return UserTypeResolver::class;
        }

        return parent::resolveFieldTypeResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}
    
// Static Initialization: Attach
GD_DataLoad_FieldResolver_Comments::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
