<?php
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class GD_GravityForms implements MutationResolverInterface
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        // $execution_response = do_shortcode('[gravityform id="'.$form_id.'" title="false" description="false" ajax="false"]');
        return RGForms::get_form($form_data['form_id'], false, false);
    }
}
