<?php


class GD_CreateOrUpdate_Stance extends GD_CreateUpdate_Stance
{
    public function validate(array $form_data): ?array
    {
        $errors = [];
        // If there's post_id => It's Update
        // Otherwise => It's Create
        $post_id = $_REQUEST[POP_INPUTNAME_POSTID];

        if ($post_id) {
            // If already exists any of these errors above, return errors
            $this->validateupdate($errors);
            if ($errors) {
                return $errors;
            }
            $this->validateupdatecontent($errors, $form_data);
        } else {
            // If already exists any of these errors above, return errors
            $this->validatecreate($errors);
            if ($errors) {
                return $errors;
            }
            $this->validatecreatecontent($errors, $form_data);
        }
        $this->validatecontent($errors, $form_data);
        return $errors;
    }

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
