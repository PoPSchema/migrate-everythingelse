<?php

use PoPSchema\CustomPostMutations\MutationResolvers\CreateCustomPostMutationResolverTrait;

class GD_Create_Event extends GD_CreateUpdate_Event
{
    use CreateCustomPostMutationResolverTrait;
}

