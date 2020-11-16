<?php


class GD_CreateOrUpdate_Stance extends GD_CreateUpdate_Stance
{
    public function validateErrors(array $form_data): ?array
    {
        $errors = [];
        // If there's post_id => It's Update
        // Otherwise => It's Create
        $post_id = $this->getUpdateCustomPostID();

        if ($post_id) {
            // If already exists any of these errors above, return errors
            $this->validateUpdate($errors);
            if ($errors) {
                return $errors;
            }
            $this->validateUpdateContent($errors, $form_data);
        } else {
            // If already exists any of these errors above, return errors
            $this->validateCreate($errors);
            if ($errors) {
                return $errors;
            }
            $this->validateCreateContent($errors, $form_data);
        }
        $this->validateContent($errors, $form_data);
        return $errors;
    }

    /**
     * @return mixed
     */
    public function execute(array $form_data)
    {
        // If there's post_id => It's Update
        // Otherwise => It's Create
        $post_id = $this->getUpdateCustomPostID();
        if ($post_id) {
            return $this->update($form_data);
        }
        return $this->create($form_data);
    }
}
