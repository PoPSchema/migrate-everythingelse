<?php
use PoP\Users\TypeResolvers\UserTypeResolver;

class PoP_SocialMediaProviders_DataLoad_FunctionalFieldResolver_UserSocialMediaItems extends PoP_SocialMediaProviders_DataLoad_FieldResolver_FunctionalSocialMediaItems
{
    public static function getClassesToAttachTo(): array
    {
        return array(
            UserTypeResolver::class,
        );
    }

    protected function getTitleField()
    {
        return 'display-name';
    }
}
    
// Static Initialization: Attach
PoP_SocialMediaProviders_DataLoad_FunctionalFieldResolver_UserSocialMediaItems::attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
