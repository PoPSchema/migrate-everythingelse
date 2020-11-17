<?php

use PoPSchema\CustomPostMutations\MutationResolvers\UpdateCustomPostMutationResolverTrait;

class GD_Update_PostLink extends GD_CreateUpdate_PostLink
{
    use UpdateCustomPostMutationResolverTrait;
}
