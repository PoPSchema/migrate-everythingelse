<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\GeneralUtils;
use PoP\Engine\Route\RouteUtils;
use PoP\Users\TypeResolvers\UserTypeResolver;

class GD_SocialNetwork_DataLoad_FieldResolver_FunctionalUsers extends AbstractFunctionalFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'followuser-url',
            'unfollowuser-url',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'followuser-url' => SchemaDefinition::TYPE_URL,
            'unfollowuser-url' => SchemaDefinition::TYPE_URL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'followuser-url' => $translationAPI->__('', ''),
            'unfollowuser-url' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $user = $resultItem;
        switch ($fieldName) {
            case 'followuser-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_USERID => $typeResolver->getId($user), 
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_FOLLOWUSER));

            case 'unfollowuser-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_USERID => $typeResolver->getId($user), 
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_UNFOLLOWUSER));
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
    
// Static Initialization: Attach
GD_SocialNetwork_DataLoad_FieldResolver_FunctionalUsers::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
