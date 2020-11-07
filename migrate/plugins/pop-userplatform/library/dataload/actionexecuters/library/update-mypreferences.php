<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class GD_UpdateMyPreferences extends AbstractMutationResolver
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        return $this->executeUpdate($errors, $form_data);
    }

    protected function executeUpdate(&$errors, $form_data)
    {
        $user_id = $form_data['user_id'];
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_USERPREFERENCES, $form_data['userPreferences']);

        return true;
    }
}

