<?php
use PoP\ComponentModel\Utils;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\ComponentModel\GeneralUtils;
use PoP\Engine\Route\RouteUtils;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\ComponentModel\Schema\TypeCastingHelpers;

class PoP_Application_DataLoad_FieldResolver_FunctionalPosts extends AbstractFunctionalFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            PostTypeResolver::class,
        );
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'multilayout-keys',
            'latestcounts-trigger-values',
            'cats-byname',
            'comments-lazy',
            'noheadercomments-lazy',
            'addcomment-url',
            'topics-byname',
            'appliesto-byname',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'multilayout-keys' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
            'latestcounts-trigger-values' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
            'cats-byname' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
            'comments-lazy' => SchemaDefinition::TYPE_ARRAY,
            'noheadercomments-lazy' => SchemaDefinition::TYPE_ARRAY,
            'addcomment-url' => SchemaDefinition::TYPE_URL,
            'topics-byname' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
            'appliesto-byname' => TypeCastingHelpers::combineTypes(SchemaDefinition::TYPE_ARRAY, SchemaDefinition::TYPE_STRING),
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'multilayout-keys' => $translationAPI->__('', ''),
            'latestcounts-trigger-values' => $translationAPI->__('', ''),
            'cats-byname' => $translationAPI->__('', ''),
            'comments-lazy' => $translationAPI->__('', ''),
            'noheadercomments-lazy' => $translationAPI->__('', ''),
            'addcomment-url' => $translationAPI->__('', ''),
            'topics-byname' => $translationAPI->__('', ''),
            'appliesto-byname' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmsengineapi = \PoP\Engine\FunctionAPIFactory::getInstance();
        $post = $resultItem;
        switch ($fieldName) {
            case 'multilayout-keys':
                // Allow pop-categorypostlayouts to add more layouts
                return HooksAPIFacade::getInstance()->applyFilters(
                    'PoP_Application:TypeResolver_Posts:multilayout-keys',
                    array(
                        $typeResolver->resolveValue($post, 'post-type', $variables, $expressions, $options),
                    ),
                    $typeResolver->getId($post)
                );

            case 'latestcounts-trigger-values':
                $value = array();
                $post_type = $typeResolver->resolveValue($post, 'post-type', $variables, $expressions, $options);
                // If it has categories, use it. Otherwise, only use the post type
                if ($cats = $typeResolver->resolveValue($post, 'cats', $variables, $expressions, $options)) {
                    foreach ($cats as $cat) {
                        $value[] = $post_type.'-'.$cat;
                    }
                } else {
                    $value[] = $post_type;
                }
                return $value;

         // Needed for using handlebars helper "compare" to compare a category id in a buttongroup, which is taken as a string, inside a list of cats, which must then also be strings
            case 'cats-byname':
                $cats = $typeResolver->resolveValue($post, 'cats', $variables, $expressions, $options);
                $value = array();
                foreach ($cats as $cat) {
                    $value[] = strval($cat);
                }
                return $value;

            case 'comments-lazy':
            case 'noheadercomments-lazy':
                return array();

            case 'addcomment-url':
                $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
                $post_name = $moduleprocessor_manager->getProcessor([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_COMMENTPOST])->getName([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::MODULE_FORMCOMPONENT_CARD_COMMENTPOST]);
                return GeneralUtils::addQueryArgs([
                    $post_name => $typeResolver->getId($post), 
                ], RouteUtils::getRouteURL(POP_ADDCOMMENTS_ROUTE_ADDCOMMENT));

            case 'topics-byname':
                $selected = $typeResolver->resolveValue($post, 'topics', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $categories = new GD_FormInput_Categories($params);
                return $categories->getSelectedValue();

            case 'appliesto-byname':
                $selected = $typeResolver->resolveValue($post, 'appliesto', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $appliesto = new GD_FormInput_AppliesTo($params);
                return $appliesto->getSelectedValue();
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
    
// Static Initialization: Attach
PoP_Application_DataLoad_FieldResolver_FunctionalPosts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
