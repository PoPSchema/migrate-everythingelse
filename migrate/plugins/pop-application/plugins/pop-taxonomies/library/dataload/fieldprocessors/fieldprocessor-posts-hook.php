<?php
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\CustomPosts\FieldInterfaces\CustomPostFieldInterfaceResolver;

class PoP_Application_Taxonomy_DataLoad_FieldResolver_Posts extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            CustomPostFieldInterfaceResolver::class,
        );
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'cat',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        // TODO: After implementing the resolver for categories change the type to ID
        $types = [
			'cat' => SchemaDefinition::TYPE_ID,//SchemaDefinition::TYPE_UNRESOLVED_ID,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'cat' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $post = $resultItem;
        switch ($fieldName) {
            // Override to make sure the category comes from the main ones
            case 'cat':
                if ($main_cat = getTheMainCategory($typeResolver->getID($post))) {
                    return $main_cat;
                }
                return null;
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
PoP_Application_Taxonomy_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
