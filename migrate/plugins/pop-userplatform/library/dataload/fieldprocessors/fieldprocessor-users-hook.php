<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Users\TypeResolvers\UserTypeResolver;

class GD_UserPlatform_DataLoad_FieldResolver_Users extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(UserTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'short-description',
            'title',
            'display-email',
            'contact',
            'has-contact',
            'facebook',
            'twitter',
            'linkedin',
            'youtube',
            'instagram',
            'is-profile',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'short-description' => SchemaDefinition::TYPE_STRING,
            'title' => SchemaDefinition::TYPE_STRING,
            'display-email' => SchemaDefinition::TYPE_EMAIL,
            'contact' => SchemaDefinition::TYPE_STRING,
            'has-contact' => SchemaDefinition::TYPE_BOOL,
            'facebook' => SchemaDefinition::TYPE_URL,
            'twitter' => SchemaDefinition::TYPE_URL,
            'linkedin' => SchemaDefinition::TYPE_URL,
            'youtube' => SchemaDefinition::TYPE_URL,
            'instagram' => SchemaDefinition::TYPE_URL,
            'is-profile' => SchemaDefinition::TYPE_BOOL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'short-description' => $translationAPI->__('', ''),
            'title' => $translationAPI->__('', ''),
            'display-email' => $translationAPI->__('', ''),
            'contact' => $translationAPI->__('', ''),
            'has-contact' => $translationAPI->__('', ''),
            'facebook' => $translationAPI->__('', ''),
            'twitter' => $translationAPI->__('', ''),
            'linkedin' => $translationAPI->__('', ''),
            'youtube' => $translationAPI->__('', ''),
            'instagram' => $translationAPI->__('', ''),
            'is-profile' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $user = $resultItem;

        switch ($fieldName) {
            case 'short-description':
                return gdGetUserShortdescription($typeResolver->getID($user));

            case 'title':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_TITLE, true);

            case 'display-email':
                return (bool)\PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_DISPLAYEMAIL, true);

         // Override
            case 'contact':
                $value = array();
                // This one is a quasi copy/paste from the typeResolver
                if ($user_url = $typeResolver->resolveValue($user, 'website-url', $variables, $expressions, $options)) {
                    $value[] = array(
                        'tooltip' => TranslationAPIFacade::getInstance()->__('Website', 'pop-coreprocessors'),
                        'url' => maybeAddHttp($user_url),
                        'text' => $user_url,
                        'target' => '_blank',
                        'fontawesome' => 'fa-home',
                    );
                }
                if ($typeResolver->resolveValue($user, 'display-email', $variables, $expressions, $options)) {
                    if ($email = $typeResolver->resolveValue($user, 'email', $variables, $expressions, $options)) {
                        $value[] = array(
                            'fontawesome' => 'fa-envelope',
                            'tooltip' => TranslationAPIFacade::getInstance()->__('Email', 'pop-coreprocessors'),
                            'url' => 'mailto:'.$email,
                            'text' => $email
                        );
                    }
                }
                // if ($blog = $typeResolver->resolveValue($user, 'blog', $variables, $expressions, $options)) {

                //     $value[] = array(
                //         'tooltip' => TranslationAPIFacade::getInstance()->__('Blog', 'poptheme-wassup'),
                //         'url' => maybeAddHttp($blog),
                //         'text' => $blog,
                //         'target' => '_blank',
                //         'fontawesome' => 'fa-pencil',
                //     );
                // }
                if ($facebook = $typeResolver->resolveValue($user, 'facebook', $variables, $expressions, $options)) {
                    $value[] = array(
                        'tooltip' => TranslationAPIFacade::getInstance()->__('Facebook', 'poptheme-wassup'),
                        'fontawesome' => 'fa-facebook',
                        'url' => maybeAddHttp($facebook),
                        'text' => $facebook,
                        'target' => '_blank'
                    );
                }
                if ($twitter = $typeResolver->resolveValue($user, 'twitter', $variables, $expressions, $options)) {
                    $value[] = array(
                        'tooltip' => TranslationAPIFacade::getInstance()->__('Twitter', 'poptheme-wassup'),
                        'fontawesome' => 'fa-twitter',
                        'url' => maybeAddHttp($twitter),
                        'text' => $twitter,
                        'target' => '_blank'
                    );
                }
                if ($linkedin = $typeResolver->resolveValue($user, 'linkedin', $variables, $expressions, $options)) {
                    $value[] = array(
                        'tooltip' => TranslationAPIFacade::getInstance()->__('LinkedIn', 'poptheme-wassup'),
                        'url' => maybeAddHttp($linkedin),
                        'text' => $linkedin,
                        'target' => '_blank',
                        'fontawesome' => 'fa-linkedin'
                    );
                }
                if ($youtube = $typeResolver->resolveValue($user, 'youtube', $variables, $expressions, $options)) {
                    $value[] = array(
                        'tooltip' => TranslationAPIFacade::getInstance()->__('Youtube', 'poptheme-wassup'),
                        'url' => maybeAddHttp($youtube),
                        'text' => $youtube,
                        'target' => '_blank',
                        'fontawesome' => 'fa-youtube',
                    );
                }
                if ($instagram = $typeResolver->resolveValue($user, 'instagram', $variables, $expressions, $options)) {
                    $value[] = array(
                        'tooltip' => TranslationAPIFacade::getInstance()->__('Instagram', 'poptheme-wassup'),
                        'url' => maybeAddHttp($instagram),
                        'text' => $instagram,
                        'target' => '_blank',
                        'fontawesome' => 'fa-instagram',
                    );
                }
                return $value;

            case 'has-contact':
                $contact = $typeResolver->resolveValue($resultItem, 'contact', $variables, $expressions, $options);
                return !empty($contact);

            case 'facebook':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_FACEBOOK, true);

            case 'twitter':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_TWITTER, true);

            case 'linkedin':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_LINKEDIN, true);

            case 'youtube':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_YOUTUBE, true);

            case 'instagram':
                return \PoP\UserMeta\Utils::getUserMeta($typeResolver->getID($user), GD_METAKEY_PROFILE_INSTAGRAM, true);

            case 'is-profile':
                return isProfile($typeResolver->getID($user));
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
GD_UserPlatform_DataLoad_FieldResolver_Users::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
