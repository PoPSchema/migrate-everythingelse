<?php
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\CustomPosts\FieldInterfaces\CustomPostFieldInterfaceResolver;

class PoP_AddPostLinks_DataLoad_FieldResolver_Posts extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return [
            CustomPostFieldInterfaceResolver::class,
        ];
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'link',
            'hasLink',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'link' => SchemaDefinition::TYPE_URL,
            'hasLink' => SchemaDefinition::TYPE_BOOL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function isSchemaFieldResponseNonNullable(TypeResolverInterface $typeResolver, string $fieldName): bool
    {
        $nonNullableFieldNames = [
            'hasLink',
        ];
        if (in_array($fieldName, $nonNullableFieldNames)) {
            return true;
        }
        return parent::isSchemaFieldResponseNonNullable($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'link' => $translationAPI->__('', ''),
            'hasLink' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $post = $resultItem;
        switch ($fieldName) {
            case 'link':
                return PoP_AddPostLinks_Utils::getLink($typeResolver->getID($post));

            case 'hasLink':
                $link = $typeResolver->resolveValue($post, 'link', $variables, $expressions, $options);
                if (GeneralUtils::isError($link)) {
                    return $link;
                } elseif ($link) {
                    return true;
                }
                return false;
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
PoP_AddPostLinks_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
