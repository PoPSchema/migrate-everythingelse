<?php
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;

class GD_GravityForms extends AbstractMutationResolver
{
    public function execute(array $form_data)
    {
        // $execution_response = do_shortcode('[gravityform id="'.$form_id.'" title="false" description="false" ajax="false"]');
        return RGForms::get_form($form_data['form_id'], false, false);
    }
}
