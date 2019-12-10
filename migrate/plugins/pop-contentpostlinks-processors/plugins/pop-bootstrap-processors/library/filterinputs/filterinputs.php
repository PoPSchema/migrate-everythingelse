<?php
class PoP_ContentPostLinksCreation_Module_Processor_CreateUpdatePostMultiSelectFilterInputProcessor extends \PoP\ComponentModel\AbstractFilterInputProcessor
{
    public const FILTERINPUT_LINKCATEGORIES = 'filterinput-linkcategories';
    public const FILTERINPUT_LINKACCESS = 'filterinput-linkaccess';

    public function getFilterInputsToProcess()
    {
        return array(
            [self::class, self::FILTERINPUT_LINKCATEGORIES],
            [self::class, self::FILTERINPUT_LINKACCESS],
        );
    }

    public function filterDataloadQueryArgs(array $filterInput, array &$query, $value)
    {
        switch ($filterInput[1]) {
            case self::FILTERINPUT_LINKCATEGORIES:
                $query['meta-query'][] = [
                    'key' => \PoP\PostMeta\Utils::getMetaKey(GD_METAKEY_POST_LINKCATEGORIES),
                    'value' => $value,
                    'compare' => 'IN',
                ];
                break;
            
            case self::FILTERINPUT_LINKACCESS:
                $query['meta-query'][] = [
                    'key' => \PoP\PostMeta\Utils::getMetaKey(GD_METAKEY_POST_LINKACCESS),
                    'value' => $value,
                    'compare' => 'IN',
                ];
                break;
        }
    }
}



