<?php
namespace PoP\UserRoles;

use PoP\ComponentModel\GeneralUtils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Users\TypeResolvers\UserTypeResolver;

class FieldResolver_Users extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'role',
			'hasRole',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'role' => SchemaDefinition::TYPE_STRING,
			'hasRole' => SchemaDefinition::TYPE_BOOL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'role' => $translationAPI->__('', ''),
			'hasRole' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function getSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        switch ($fieldName) {
            case 'hasRole':
                return [
                    [
                        SchemaDefinition::ARGNAME_NAME => 'role',
                        SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_STRING,
                        SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('The role name to compare against', 'user-roles'),
                        SchemaDefinition::ARGNAME_MANDATORY => true,
                    ],
                ];
        }

        return parent::getSchemaFieldArgs($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmsuserrolesapi = FunctionAPIFactory::getInstance();
        $user = $resultItem;
        switch ($fieldName) {
            case 'role':
                $user_roles = $cmsuserrolesapi->getUserRoles($typeResolver->getID($user));
                // Allow to hook for URE: Make sure we always get the most specific role
                // Otherwise, users like Leo get role 'administrator'
                return HooksAPIFacade::getInstance()->applyFilters(
                    'UserTypeResolver:getValue:role',
                    array_shift($user_roles),
                    $typeResolver->getID($user)
                );
            case 'hasRole':
                $role = $typeResolver->resolveValue($user, 'role', $variables, $expressions, $options);
                if (GeneralUtils::isError($role)) {
                    return $role;
                }
                return $role == $fieldArgs['role'];
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
FieldResolver_Users::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
