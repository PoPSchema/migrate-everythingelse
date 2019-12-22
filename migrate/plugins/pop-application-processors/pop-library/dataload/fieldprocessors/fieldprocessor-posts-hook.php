<?php
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;

class GD_ApplicationProcessors_DataLoad_FieldResolver_Posts extends AbstractDBDataFieldResolver
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
			'highlights-lazy',
            'referencedby-lazy',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'highlights-lazy' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
            'referencedby-lazy' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ID),
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'highlights-lazy' => $translationAPI->__('', ''),
            'referencedby-lazy' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $post = $resultItem;
        switch ($fieldName) {
            case 'highlights-lazy':
            case 'referencedby-lazy':
                return array();
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
GD_ApplicationProcessors_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
