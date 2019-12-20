<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Posts\TypeResolvers\PostUnionTypeResolver;

class PoP_RelatedPosts_DataLoad_FieldResolver_Posts extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            PostTypeResolver::class,
        );
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'references',
            'has-references',
            'referencedby',
            'has-referencedby',
            'referencedby-count',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'references' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
            'has-references' => SchemaDefinition::TYPE_BOOL,
            'referencedby' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
            'has-referencedby' => SchemaDefinition::TYPE_BOOL,
            'referencedby-count' => SchemaDefinition::TYPE_INT,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'references' => $translationAPI->__('', ''),
            'has-references' => $translationAPI->__('', ''),
            'referencedby' => $translationAPI->__('', ''),
            'has-referencedby' => $translationAPI->__('', ''),
            'referencedby-count' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $post = $resultItem;
        switch ($fieldName) {
            case 'references':
                return \PoP\PostMeta\Utils::getPostMeta($typeResolver->getID($post), GD_METAKEY_POST_REFERENCES);

            case 'has-references':
                $references = $typeResolver->resolveValue($resultItem, 'references', $variables, $expressions, $options);
                return !empty($references);

            case 'referencedby':
                return PoP_RelatedPosts_SectionUtils::getReferencedby($typeResolver->getID($post));

            case 'has-referencedby':
                $referencedby = $typeResolver->resolveValue($resultItem, 'referencedby', $variables, $expressions, $options);
                return !empty($referencedby);

            case 'referencedby-count':
                $referencedby = $typeResolver->resolveValue($resultItem, 'referencedby', $variables, $expressions, $options);
                return count($referencedby);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function resolveFieldTypeResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'references':
            case 'referencedby':
                return PostUnionTypeResolver::class;
        }

        return parent::resolveFieldTypeResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}

// Static Initialization: Attach
PoP_RelatedPosts_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
