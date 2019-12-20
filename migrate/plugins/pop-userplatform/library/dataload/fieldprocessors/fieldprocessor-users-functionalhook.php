<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Users\TypeResolvers\UserTypeResolver;

class GD_UserPlatform_DataLoad_FieldResolver_FunctionalUsers extends AbstractFunctionalFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'short-description-formatted',
            'contact-small',
            'user-preferences',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'short-description-formatted' => SchemaDefinition::TYPE_STRING,
            'contact-small' => SchemaDefinition::TYPE_STRING,
            'user-preferences' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'short-description-formatted' => $translationAPI->__('', ''),
            'contact-small' => $translationAPI->__('', ''),
            'user-preferences' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $user = $resultItem;
        $cmsapplicationhelpers = \PoP\Application\HelperAPIFactory::getInstance();
        switch ($fieldName) {
            case 'short-description-formatted':
                // doing esc_html so that single quotes ("'") do not screw the map output
                $value = $typeResolver->resolveValue($user, 'short-description', $variables, $expressions, $options);
                return $cmsapplicationhelpers->makeClickable($cmsapplicationhelpers->escapeHTML($value));

            case 'contact-small':
                $value = array();
                $contacts = $typeResolver->resolveValue($user, 'contact', $variables, $expressions, $options);
                // Remove text, replace all icons with their shorter version
                foreach ($contacts as $contact) {
                    $value[] = array(
                        'tooltip' => $contact['tooltip'],
                        'url' => $contact['url'],
                        'fontawesome' => $contact['fontawesome']
                    );
                }
                return $value;

         // User preferences
            case 'user-preferences':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_USERPREFERENCES);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
GD_UserPlatform_DataLoad_FieldResolver_FunctionalUsers::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
