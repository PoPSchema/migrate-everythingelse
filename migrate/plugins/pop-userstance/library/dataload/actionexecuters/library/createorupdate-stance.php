<?php


class GD_CreateOrUpdate_Stance extends GD_CreateUpdate_Stance
{
    public function execute(array &$errors)
    {
        // If there's post_id => It's Update
        // Otherwise => It's Create
        $post_id = $_REQUEST[POP_INPUTNAME_POSTID];

        if ($post_id) {
            $this->update($errors);
        } else {
            $post_id = $this->create($errors);
        }

        return $post_id;
    }
}
