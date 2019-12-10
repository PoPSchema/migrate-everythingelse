<?php
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;

trait CommunityFieldResolverTrait
{
    public function resolveCanProcessResultItem(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): bool
    {
        $user = $resultItem;
        if (!gdUreIsCommunity($typeResolver->getId($user))) {
            return false;
        }
        return parent::resolveCanProcessResultItem($typeResolver, $resultItem, $fieldName, $fieldArgs);
    }
}
