<?php
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class GD_UpdateMyPreferences implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        $this->validate($errors, $form_data);

        if ($errors) {
            return;
        }

        return $this->executeUpdate($errors, $form_data);
    }

    protected function validate(&$errors, &$form_data)
    {
    }

    protected function executeUpdate(&$errors, $form_data)
    {
        $user_id = $form_data['user_id'];
        \PoPSchema\UserMeta\Utils::updateUserMeta($user_id, GD_METAKEY_PROFILE_USERPREFERENCES, $form_data['userPreferences']);

        return true;
    }
}

