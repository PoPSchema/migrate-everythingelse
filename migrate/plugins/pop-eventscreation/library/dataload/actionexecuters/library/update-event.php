<?php

use PoPSchema\CustomPostMutations\MutationResolvers\UpdateCustomPostMutationResolverTrait;

class GD_Update_Event extends GD_CreateUpdate_Event
{
    use UpdateCustomPostMutationResolverTrait;
}

