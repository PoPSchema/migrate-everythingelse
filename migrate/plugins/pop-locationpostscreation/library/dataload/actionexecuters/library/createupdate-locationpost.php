<?php
use PoPSitesWassup\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolver;

abstract class GD_CreateUpdate_LocationPost extends AbstractCreateUpdateCustomPostMutationResolver
{
    public function getCustomPostType(): string
    {
        return POP_LOCATIONPOSTS_POSTTYPE_LOCATIONPOST;
    }

    protected function volunteer()
    {
        return true;
    }

    /**
     * @param mixed $post_id
     */
    protected function additionals($post_id, array $form_data): void
    {
        parent::additionals($post_id, $form_data);

        // Locations
        \PoPSchema\CustomPostMeta\Utils::updateCustomPostMeta($post_id, GD_METAKEY_POST_LOCATIONS, $form_data['locations']);
    }
}
