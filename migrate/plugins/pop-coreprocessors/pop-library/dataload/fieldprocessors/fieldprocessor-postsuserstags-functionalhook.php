<?php
use PoP\Users\TypeResolvers\UserTypeResolver;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Taxonomies\TypeResolvers\TagTypeResolver;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Content\FieldInterfaces\ContentEntityFieldInterfaceResolver;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;

class GD_DataLoad_FunctionalFieldResolver extends AbstractFunctionalFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            ContentEntityFieldInterfaceResolver::class,
            UserTypeResolver::class,
            TagTypeResolver::class,
        );
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'print-url',
            'embed-url',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'print-url' => SchemaDefinition::TYPE_URL,
            'embed-url' => SchemaDefinition::TYPE_URL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'print-url' => $translationAPI->__('', ''),
            'embed-url' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        switch ($fieldName) {
            case 'print-url':
                $url = $typeResolver->resolveValue($resultItem, 'url', $variables, $expressions, $options);
                return PoP_Application_Engine_Utils::getPrintUrl($url);

            case 'embed-url':
                $url = $typeResolver->resolveValue($resultItem, 'url', $variables, $expressions, $options);
                return PoP_Application_Engine_Utils::getEmbedUrl($url);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
GD_DataLoad_FunctionalFieldResolver::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
