<?php
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;

trait IndividualFieldResolverTrait
{
    public function resolveCanProcessResultItem(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = []): bool
    {
        $user = $resultItem;
        if (!gdUreIsIndividual($typeResolver->getId($user))) {
            return false;
        }
        return parent::resolveCanProcessResultItem($typeResolver, $resultItem, $fieldName, $fieldArgs);
    }
}
