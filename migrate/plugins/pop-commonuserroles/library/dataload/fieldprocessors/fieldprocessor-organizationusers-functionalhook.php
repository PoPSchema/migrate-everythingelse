<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Users\TypeResolvers\UserTypeResolver;

class GD_URE_Custom_DataLoad_FieldResolver_FunctionalOrganizationUsers extends AbstractFunctionalFieldResolver
{
    use OrganizationFieldResolverTrait;

    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'organizationtypes-byname',
            'organizationcategories-byname',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'organizationtypes-byname' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
            'organizationcategories-byname' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'organizationtypes-byname' => $translationAPI->__('', ''),
            'organizationcategories-byname' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $user = $resultItem;
        switch ($fieldName) {
            case 'organizationtypes-byname':
                $selected = $typeResolver->resolveValue($user, 'organizationtypes', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $organizationtypes = new GD_FormInput_OrganizationTypes($params);
                return $organizationtypes->getSelectedValue();

            case 'organizationcategories-byname':
                $selected = $typeResolver->resolveValue($user, 'organizationcategories', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $organizationcategories = new GD_FormInput_OrganizationCategories($params);
                return $organizationcategories->getSelectedValue();
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
    
// Static Initialization: Attach
GD_URE_Custom_DataLoad_FieldResolver_FunctionalOrganizationUsers::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
