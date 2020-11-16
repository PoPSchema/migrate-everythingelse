<?php

use PoPSchema\CustomPostMutations\MutationResolvers\MutationInputProperties;


class GD_CreateOrUpdate_Stance extends GD_CreateUpdate_Stance
{
    /**
     * @return mixed
     */
    public function execute(array $form_data)
    {
        // If there's post_id => It's Update
        // Otherwise => It's Create
        $customPostID = $form_data[MutationInputProperties::ID];
        if ($customPostID) {
            return $this->update($form_data);
        }
        return $this->create($form_data);
    }
}
