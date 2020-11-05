<?php
use PoP\ComponentModel\ModuleProcessors\DataloadingConstants;
use PoPSchema\PostMutations\MutationResolvers\AbstractCreateUpdatePostMutationResolverBridge;

abstract class GD_DataLoad_ActionExecuter_CreateUpdate_Event extends AbstractCreateUpdatePostMutationResolverBridge
{
    public function modifyDataProperties(&$data_properties, $post_id)
    {
        // Modify the block-data-settings, saying to select the id of the newly created post
        $data_properties[DataloadingConstants::QUERYARGS]['include'] = array($post_id);
        $data_properties[DataloadingConstants::QUERYARGS]['status'] = array('pending', 'draft', 'published');
    }
}

