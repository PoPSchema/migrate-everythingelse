<?php
use PoP\Engine\Route\RouteUtils;
use PoP\ComponentModel\GeneralUtils;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Content\FieldInterfaces\ContentEntityFieldInterfaceResolver;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;

class PoP_EventLinksCreation_DataLoad_FunctionalFieldResolver extends AbstractFunctionalFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            ContentEntityFieldInterfaceResolver::class,
        );
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'addeventlink-url',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'addeventlink-url' => SchemaDefinition::TYPE_URL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'addeventlink-url' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $post = $resultItem;
        switch ($fieldName) {
            case 'addeventlink-url':
                $routes = array(
                    'addeventlink-url' => POP_EVENTLINKSCREATION_ROUTE_ADDEVENTLINK,
                );
                $route = $routes[$fieldName];

                // $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
                // $name = $moduleprocessor_manager->getProcessor([PoP_Module_Processor_PostSelectableTypeaheadFormComponents::class, PoP_Module_Processor_PostSelectableTypeaheadFormComponents::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEAD_REFERENCES])->getInputName([PoP_Module_Processor_PostSelectableTypeaheadFormComponents::class, PoP_Module_Processor_PostSelectableTypeaheadFormComponents::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEAD_REFERENCES]);
                $name = POP_INPUTNAME_REFERENCES.'[]';
                return GeneralUtils::addQueryArgs([
                    $name => $typeResolver->getID($post),
                ], RouteUtils::getRouteURL($route));
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
PoP_EventLinksCreation_DataLoad_FunctionalFieldResolver::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
