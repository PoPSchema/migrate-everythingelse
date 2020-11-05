<?php

use PoPSchema\PostMutations\MutationResolvers\UpdatePostMutationResolverTrait;

class GD_Update_Event extends GD_CreateUpdate_Event
{
    use UpdatePostMutationResolverTrait;
}

