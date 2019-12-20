<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Users\TypeResolvers\UserTypeResolver;

class PoP_Application_DataLoad_FieldResolver_FunctionalUsers extends AbstractFunctionalFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            UserTypeResolver::class,
        );
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'multilayout-keys',
            'mention-queryby',
            'description-formatted',
            'excerpt',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'multilayout-keys' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
            'mention-queryby' => SchemaDefinition::TYPE_STRING,
            'description-formatted' => SchemaDefinition::TYPE_STRING,
            'excerpt' => SchemaDefinition::TYPE_STRING,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'multilayout-keys' => $translationAPI->__('', ''),
            'mention-queryby' => $translationAPI->__('', ''),
            'description-formatted' => $translationAPI->__('', ''),
            'excerpt' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $user = $resultItem;
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        $cmsapplicationhelpers = \PoP\Application\HelperAPIFactory::getInstance();
        switch ($fieldName) {
            case 'multilayout-keys':
                return array(
                    $typeResolver->resolveValue($user, 'role', $variables, $expressions, $options),
                );

             // Needed for tinyMCE-mention plug-in
            case 'mention-queryby':
                return $typeResolver->resolveValue($user, 'display-name', $variables, $expressions, $options);

            case 'description-formatted':
                $value = $typeResolver->resolveValue($user, 'description', $variables, $expressions, $options);
                return $cmsapplicationhelpers->makeClickable($cmsapplicationhelpers->convertLinebreaksToHTML(strip_tags($value)));

            case 'excerpt':
                $readmore = sprintf(
                    TranslationAPIFacade::getInstance()->__('... <a href="%s">Read more</a>', 'pop-application'),
                    $cmsusersapi->getUserURL($typeResolver->getID($user))
                );
                // Excerpt length can be set through fieldArgs
                $length = $fieldArgs['length'] ? (int) $fieldArgs['length'] : 300;
                return $cmsapplicationhelpers->makeClickable(limitString(strip_tags($cmsapplicationhelpers->convertLinebreaksToHTML($cmsusersapi->getUserDescription($typeResolver->getID($user)))), $length, $readmore));
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
PoP_Application_DataLoad_FieldResolver_FunctionalUsers::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
