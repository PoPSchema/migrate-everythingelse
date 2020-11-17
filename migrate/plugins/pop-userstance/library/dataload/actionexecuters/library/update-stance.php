<?php

use PoPSchema\CustomPostMutations\MutationResolvers\UpdateCustomPostMutationResolverTrait;

class GD_Update_Stance extends GD_CreateUpdate_Stance
{
    use UpdateCustomPostMutationResolverTrait;
}
