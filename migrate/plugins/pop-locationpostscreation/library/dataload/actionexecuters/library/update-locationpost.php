<?php

use PoPSchema\CustomPostMutations\MutationResolvers\UpdateCustomPostMutationResolverTrait;

class GD_Update_LocationPost extends GD_CreateUpdate_LocationPost
{
    use UpdateCustomPostMutationResolverTrait;
}
