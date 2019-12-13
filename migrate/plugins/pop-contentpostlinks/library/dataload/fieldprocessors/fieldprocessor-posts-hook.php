<?php
use PoP\ComponentModel\Utils;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\ComponentModel\Schema\TypeCastingHelpers;

class PoP_ContentPostLinks_DataLoad_FieldResolver_Posts extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(PostTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'excerpt',
            'content',
            'linkcontent',
            'linkaccess',
            'linkaccess-byname',
            'linkcategories',
            'linkcategories-byname',
            'has-linkcategories',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'excerpt' => SchemaDefinition::TYPE_STRING,
            'content' => SchemaDefinition::TYPE_STRING,
            'linkcontent' => SchemaDefinition::TYPE_STRING,
            'linkaccess' => SchemaDefinition::TYPE_ENUM,
            'linkaccess-byname' => SchemaDefinition::TYPE_STRING,
            'linkcategories' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ENUM),
            'linkcategories-byname' => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_STRING),
            'has-linkcategories' => SchemaDefinition::TYPE_BOOL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'excerpt' => $translationAPI->__('', ''),
            'content' => $translationAPI->__('', ''),
            'linkcontent' => $translationAPI->__('', ''),
            'linkaccess' => $translationAPI->__('', ''),
            'linkaccess-byname' => $translationAPI->__('', ''),
            'linkcategories' => $translationAPI->__('', ''),
            'linkcategories-byname' => $translationAPI->__('', ''),
            'has-linkcategories' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    protected function addSchemaDefinitionForField(array &$schemaDefinition, string $fieldName)
    {
        switch ($fieldName) {
            case 'linkaccess':
            case 'linkcategories':
                $input_classes = [
                    'linkaccess' => GD_FormInput_LinkAccessDescription::class,
                    'linkcategories' => GD_FormInput_LinkCategories::class,
                ];
                $class = $input_classes[$fieldName];
                $schemaDefinition[SchemaDefinition::ARGNAME_ENUMVALUES] = array_keys((new $class())->getAllValues());
                break;
        }
    }

    public function resolveCanProcessResultItem(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): bool
    {
        if (in_array($fieldName, [
            'excerpt',
            'content',
        ])) {
            $post = $resultItem;
            $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
            return defined('POP_CONTENTPOSTLINKS_CAT_CONTENTPOSTLINKS') && POP_CONTENTPOSTLINKS_CAT_CONTENTPOSTLINKS && $taxonomyapi->hasCategory(POP_CONTENTPOSTLINKS_CAT_CONTENTPOSTLINKS, $typeResolver->getId($post));
        }
        return true;
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $post = $resultItem;
        $taxonomyapi = \PoP\Taxonomies\FunctionAPIFactory::getInstance();
        switch ($fieldName) {

            // Override fields for Links
            case 'excerpt':
                return PoP_ContentPostLinks_Utils::getLinkExcerpt($post);
            case 'content':
                return PoP_ContentPostLinks_Utils::getLinkContent($post);

            case 'linkcontent':
                return PoP_ContentPostLinks_Utils::getLinkContent($post, true);

            case 'linkaccess':
                return \PoP\PostMeta\Utils::getPostMeta($typeResolver->getId($post), GD_METAKEY_POST_LINKACCESS, true);

            case 'linkaccess-byname':
                $selected = $typeResolver->resolveValue($post, 'linkaccess', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $linkaccess = new GD_FormInput_LinkAccessDescription($params);
                return $linkaccess->getSelectedValue();

            case 'linkcategories':
                return \PoP\PostMeta\Utils::getPostMeta($typeResolver->getId($post), GD_METAKEY_POST_LINKCATEGORIES);

            case 'linkcategories-byname':
                $selected = $typeResolver->resolveValue($post, 'linkcategories', $variables, $expressions, $options);
                $params = array(
                    'selected' => $selected
                );
                $linkcategories = new GD_FormInput_LinkCategories($params);
                return $linkcategories->getSelectedValue();

            case 'has-linkcategories':
                if ($typeResolver->resolveValue($post, 'linkcategories', $variables, $expressions, $options)) {
                    return true;
                }
                return false;
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
PoP_ContentPostLinks_DataLoad_FieldResolver_Posts::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS, 20);
