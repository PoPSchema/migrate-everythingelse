<?php
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;

trait OrganizationFieldResolverTrait
{
    public function resolveCanProcessResultItem(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): bool
    {
        $user = $resultItem;
        if (!gdUreIsOrganization($typeResolver->getId($user))) {
            return false;
        }
        return parent::resolveCanProcessResultItem($typeResolver, $resultItem, $fieldName, $fieldArgs);
    }
}
