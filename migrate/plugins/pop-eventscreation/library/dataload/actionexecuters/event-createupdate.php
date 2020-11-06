<?php
use PoP\ComponentModel\ModuleProcessors\DataloadingConstants;
use PoPSchema\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolverBridge;

abstract class GD_DataLoad_ActionExecuter_CreateUpdate_Event extends AbstractCreateUpdateCustomPostMutationResolverBridge
{
    /**
     * @param mixed $result_id Maybe an int, maybe a string
     */
    public function modifyDataProperties(array &$data_properties, $result_id): void
    {
        parent::modifyDataProperties($data_properties, $result_id);
        $data_properties[DataloadingConstants::QUERYARGS]['status'] = array('pending', 'draft', 'published');
    }
}

