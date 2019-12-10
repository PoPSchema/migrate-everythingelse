<?php
use PoP\ComponentModel\ModuleProcessors\DataloadingConstants;

class GD_DataLoad_ActionExecuter_CreateUpdate_Event extends GD_DataLoad_ActionExecuter_CreateUpdate_PostBase
{
    public function getCreateupdate()
    {
        return new GD_CreateUpdate_Event();
    }

    public function modifyDataProperties(&$data_properties, $post_id)
    {

        // Modify the block-data-settings, saying to select the id of the newly created post
        $data_properties[DataloadingConstants::QUERYARGS]['include'] = array($post_id);
        $data_properties[DataloadingConstants::QUERYARGS]['status'] = array('pending', 'draft', 'published');
    }
}
    
