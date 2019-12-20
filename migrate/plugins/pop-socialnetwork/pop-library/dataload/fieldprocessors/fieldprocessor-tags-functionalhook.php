<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\GeneralUtils;
use PoP\Engine\Route\RouteUtils;
use PoP\Taxonomies\TypeResolvers\TagTypeResolver;

class GD_DataLoad_FieldResolver_Tags extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(TagTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'subscribetotag-url',
            'unsubscribefromtag-url',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'subscribetotag-url' => SchemaDefinition::TYPE_URL,
            'unsubscribefromtag-url' => SchemaDefinition::TYPE_URL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'subscribetotag-url' => $translationAPI->__('', ''),
            'unsubscribefromtag-url' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $tag = $resultItem;
        switch ($fieldName) {
            case 'subscribetotag-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_TAGID => $typeResolver->getID($tag),
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_SUBSCRIBETOTAG));

            case 'unsubscribefromtag-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_TAGID => $typeResolver->getID($tag),
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_UNSUBSCRIBEFROMTAG));
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
GD_DataLoad_FieldResolver_Tags::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
