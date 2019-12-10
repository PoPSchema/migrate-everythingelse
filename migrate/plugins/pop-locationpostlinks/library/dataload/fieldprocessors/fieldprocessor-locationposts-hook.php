<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\LocationPosts\TypeResolvers\LocationPostTypeResolver;

class GD_Custom_Locations_ContentPostLinks_DataLoad_FieldResolver_Posts extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(LocationPostTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'excerpt',
            'content',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'excerpt' => SchemaDefinition::TYPE_STRING,
            'content' => SchemaDefinition::TYPE_STRING,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'excerpt' => $translationAPI->__('', ''),
            'content' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveCanProcessResultItem(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): bool
    {
        if (in_array($fieldName, [
            'excerpt',
            'content',
        ])) {
            $locationpost = $resultItem;
            $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
            return POP_LOCATIONPOSTLINKS_CAT_LOCATIONPOSTLINKS && $taxonomyapi->hasCategory(POP_LOCATIONPOSTLINKS_CAT_LOCATIONPOSTLINKS, $typeResolver->getId($locationpost));
        }
        return true;
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $locationpost = $resultItem;
        switch ($fieldName) {
            // Override fields for Location Post Links
            case 'excerpt':
                return PoP_ContentPostLinks_Utils::getLinkExcerpt($locationpost);
            case 'content':
                return PoP_ContentPostLinks_Utils::getLinkContent($locationpost);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
    
// Static Initialization: Attach
GD_Custom_Locations_ContentPostLinks_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS, 20);
