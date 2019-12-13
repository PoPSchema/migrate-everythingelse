<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Users\TypeResolvers\UserTypeResolver;

class FieldResolver_OrganizationUsers extends AbstractDBDataFieldResolver
{
    use OrganizationFieldResolverTrait;

    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'contact-person',
            'contact-number',
            'organizationtypes',
            'organizationcategories',
            'has-organization-details',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'contact-person' => SchemaDefinition::TYPE_STRING,
            'contact-number' => SchemaDefinition::TYPE_STRING,
            'organizationtypes' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
            'organizationcategories' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
            'has-organization-details' => SchemaDefinition::TYPE_BOOL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'contact-person' => $translationAPI->__('', ''),
            'contact-number' => $translationAPI->__('', ''),
            'organizationtypes' => $translationAPI->__('', ''),
            'organizationcategories' => $translationAPI->__('', ''),
            'has-organization-details' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $user = $resultItem;
        switch ($fieldName) {
            case 'contact-person':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getId($user), GD_URE_METAKEY_PROFILE_CONTACTPERSON, true);

            case 'contact-number':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getId($user), GD_URE_METAKEY_PROFILE_CONTACTNUMBER, true);

            case 'organizationtypes':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getId($user), GD_URE_METAKEY_PROFILE_ORGANIZATIONTYPES);

            case 'organizationcategories':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getId($user), GD_URE_METAKEY_PROFILE_ORGANIZATIONCATEGORIES);

            case 'has-organization-details':
                return
                    $typeResolver->resolveValue($user, 'organizationtypes', $variables, $expressions, $options) ||
                    $typeResolver->resolveValue($user, 'organizationcategories', $variables, $expressions, $options) ||
                    $typeResolver->resolveValue($user, 'contact-person', $variables, $expressions, $options) ||
                    $typeResolver->resolveValue($user, 'contact-number', $variables, $expressions, $options);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
FieldResolver_OrganizationUsers::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
