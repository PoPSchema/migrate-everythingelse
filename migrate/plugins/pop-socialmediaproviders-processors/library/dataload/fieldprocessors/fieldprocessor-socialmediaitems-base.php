<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractFunctionalFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\GeneralUtils;

abstract class PoP_SocialMediaProviders_DataLoad_FieldResolver_FunctionalSocialMediaItems extends AbstractFunctionalFieldResolver
{
    protected function getShareUrl($url, $title, $provider)
    {
        $settings = gdSocialmediaProviderSettings();
        $provider_url = $settings[$provider]['share-url'];
        return str_replace(array('%url%', '%title%'), array(rawurlencode($url), rawurlencode($title)), $provider_url);
    }

    protected function getTitleField()
    {
        return null;
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
			'share-url',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'share-url' => SchemaDefinition::TYPE_URL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'share-url' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function getSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        switch ($fieldName) {
            case 'share-url':
                return [
                    [
                        SchemaDefinition::ARGNAME_NAME => 'provider',
                        SchemaDefinition::ARGNAME_TYPE => SchemaDefinition::TYPE_ENUM,
                        SchemaDefinition::ARGNAME_ENUMVALUES => array_keys($this->getProviderURLs()),
                        SchemaDefinition::ARGNAME_DESCRIPTION => $translationAPI->__('What provider service to get the URL from', ''),
                        SchemaDefinition::ARGNAME_MANDATORY => true,
                    ],
                ];
        }

        return parent::getSchemaFieldArgs($typeResolver, $fieldName);
    }

    protected function getProviderURLs() {
        return [
            'facebook' => GD_SOCIALMEDIA_PROVIDER_FACEBOOK,
            'linkedin' => GD_SOCIALMEDIA_PROVIDER_LINKEDIN,
            'twitter' => GD_SOCIALMEDIA_PROVIDER_TWITTER,
        ];
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        switch ($fieldName) {
            case 'share-url':
                $url = $typeResolver->resolveValue($resultItem, 'url', $variables, $expressions, $options);
                if (GeneralUtils::isError($url)) {
                    return $url;
                }
                $title = $typeResolver->resolveValue($resultItem, $this->getTitleField(), $variables, $expressions, $options);
                if (GeneralUtils::isError($title)) {
                    return $title;
                }
                return $this->getShareUrl($url, $title, $this->getProviderURLs()[$fieldArgs['provider']]);
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
