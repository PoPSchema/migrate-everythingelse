<?php


class GD_CreateOrUpdate_Stance extends GD_CreateUpdate_Stance
{
    public function execute(array &$errors, array &$errorcodes, array $form_data)
    {
        // If there's post_id => It's Update
        // Otherwise => It's Create
        $post_id = $_REQUEST[POP_INPUTNAME_POSTID];

        if ($post_id) {
            $this->update($errors, $form_data);
        } else {
            $post_id = $this->create($errors, $form_data);
        }

        return $post_id;
    }
}
