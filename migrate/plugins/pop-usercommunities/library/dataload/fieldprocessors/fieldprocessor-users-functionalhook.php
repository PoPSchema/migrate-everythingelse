<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Users\TypeResolvers\UserTypeResolver;

class GD_UserCommunities_DataLoad_FieldResolver_FunctionalUsers extends AbstractFunctionalFieldResolver
{    
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'edit-membership-url',
            'edit-memberstatus-inline-url',
            'memberstatus-byname',
            'memberprivileges-byname',
            'membertags-byname',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'edit-membership-url' => SchemaDefinition::TYPE_URL,
            'edit-memberstatus-inline-url' => SchemaDefinition::TYPE_URL,
            'memberstatus-byname' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
            'memberprivileges-byname' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
            'membertags-byname' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'edit-membership-url' => $translationAPI->__('', ''),
            'edit-memberstatus-inline-url' => $translationAPI->__('', ''),
            'memberstatus-byname' => $translationAPI->__('', ''),
            'memberprivileges-byname' => $translationAPI->__('', ''),
            'membertags-byname' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $user = $resultItem;
        switch ($fieldName) {
            case 'edit-membership-url':
                return gdUreEditMembershipUrl($typeResolver->getId($user));

            case 'edit-memberstatus-inline-url':
                return gdUreEditMembershipUrl($typeResolver->getId($user), true);

            case 'memberstatus-byname':
                $selected = $typeResolver->resolveValue($user, 'memberstatus', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $status = new GD_URE_FormInput_MultiMemberStatus($params);
                return $status->getSelectedValue();

            case 'memberprivileges-byname':
                $selected = $typeResolver->resolveValue($user, 'memberprivileges', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $privileges = new GD_URE_FormInput_FilterMemberPrivileges($params);
                return $privileges->getSelectedValue();

            case 'membertags-byname':
                $selected = $typeResolver->resolveValue($user, 'membertags', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $tags = new GD_URE_FormInput_FilterMemberTags($params);
                return $tags->getSelectedValue();
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
    
// Static Initialization: Attach
GD_UserCommunities_DataLoad_FieldResolver_FunctionalUsers::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
