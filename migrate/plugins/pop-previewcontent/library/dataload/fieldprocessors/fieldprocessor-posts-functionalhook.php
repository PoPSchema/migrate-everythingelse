<?php
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Content\FieldInterfaces\ContentEntityFieldInterfaceResolver;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;

class PPPPoP_DataLoad_FieldResolver_FunctionalProfiles extends AbstractFunctionalFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return [
            ContentEntityFieldInterfaceResolver::class,
        ];
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'preview-url',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'preview-url' => SchemaDefinition::TYPE_URL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'preview-url' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $pluginapi = PoP_PreviewContent_FunctionsAPIFactory::getInstance();
        $post = $resultItem;
        switch ($fieldName) {
            case 'preview-url':
                // Use function getID to also cater for events (whose ID is $event->post_id)
                return $pluginapi->getPreviewLink($typeResolver->getID($post));
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
PPPPoP_DataLoad_FieldResolver_FunctionalProfiles::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
