<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\GeneralUtils;
use PoP\Engine\Route\RouteUtils;
use PoP\Posts\TypeResolvers\PostTypeResolver;

class GD_SocialNetwork_DataLoad_FieldResolver_FunctionalPosts extends AbstractFunctionalFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(PostTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'recommendpost-url',
            'unrecommendpost-url',
            'recommendpost-count-plus1',
            'upvotepost-url',
            'undoupvotepost-url',
            'upvotepost-count-plus1',
            'downvotepost-url',
            'undodownvotepost-url',
            'downvotepost-count-plus1',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'recommendpost-url' => SchemaDefinition::TYPE_URL,
            'unrecommendpost-url' => SchemaDefinition::TYPE_URL,
            'recommendpost-count-plus1' => SchemaDefinition::TYPE_INT,
            'upvotepost-url' => SchemaDefinition::TYPE_URL,
            'undoupvotepost-url' => SchemaDefinition::TYPE_URL,
            'upvotepost-count-plus1' => SchemaDefinition::TYPE_INT,
            'downvotepost-url' => SchemaDefinition::TYPE_URL,
            'undodownvotepost-url' => SchemaDefinition::TYPE_URL,
            'downvotepost-count-plus1' => SchemaDefinition::TYPE_INT,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'recommendpost-url' => $translationAPI->__('', ''),
            'unrecommendpost-url' => $translationAPI->__('', ''),
            'recommendpost-count-plus1' => $translationAPI->__('', ''),
            'upvotepost-url' => $translationAPI->__('', ''),
            'undoupvotepost-url' => $translationAPI->__('', ''),
            'upvotepost-count-plus1' => $translationAPI->__('', ''),
            'downvotepost-url' => $translationAPI->__('', ''),
            'undodownvotepost-url' => $translationAPI->__('', ''),
            'downvotepost-count-plus1' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $post = $resultItem;
        switch ($fieldName) {
            case 'recommendpost-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_POSTID => $typeResolver->getId($post), 
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_RECOMMENDPOST));

            case 'unrecommendpost-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_POSTID => $typeResolver->getId($post), 
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_UNRECOMMENDPOST));

            case 'recommendpost-count-plus1':
                if ($count = $typeResolver->resolveValue($resultItem, 'recommendpost-count', $variables, $expressions, $options)) {
                    return $count+1;
                }
                return 1;

            case 'upvotepost-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_POSTID => $typeResolver->getId($post), 
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_UPVOTEPOST));

            case 'undoupvotepost-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_POSTID => $typeResolver->getId($post), 
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_UNDOUPVOTEPOST));

            case 'upvotepost-count-plus1':
                if ($count = $typeResolver->resolveValue($resultItem, 'upvotepost-count', $variables, $expressions, $options)) {
                    return $count+1;
                }
                return 1;

            case 'downvotepost-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_POSTID => $typeResolver->getId($post), 
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_DOWNVOTEPOST));

            case 'undodownvotepost-url':
                return GeneralUtils::addQueryArgs([
                    POP_INPUTNAME_POSTID => $typeResolver->getId($post), 
                ], RouteUtils::getRouteURL(POP_SOCIALNETWORK_ROUTE_UNDODOWNVOTEPOST));

            case 'downvotepost-count-plus1':
                if ($count = $typeResolver->resolveValue($resultItem, 'downvotepost-count', $variables, $expressions, $options)) {
                    return $count+1;
                }
                return 1;
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
    
// Static Initialization: Attach
GD_SocialNetwork_DataLoad_FieldResolver_FunctionalPosts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
