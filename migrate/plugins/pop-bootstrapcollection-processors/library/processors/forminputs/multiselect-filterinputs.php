<?php
use PoP\ComponentModel\Schema\SchemaHelpers;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\TypeCastingHelpers;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\ModuleProcessors\DataloadQueryArgsFilterInputModuleProcessorInterface;
use PoP\ComponentModel\ModuleProcessors\DataloadQueryArgsSchemaFilterInputModuleProcessorTrait;
use PoP\ComponentModel\ModuleProcessors\DataloadQueryArgsSchemaFilterInputModuleProcessorInterface;

class PoP_Module_Processor_MultiSelectFilterInputs extends PoP_Module_Processor_MultiSelectFormInputsBase implements DataloadQueryArgsFilterInputModuleProcessorInterface, DataloadQueryArgsSchemaFilterInputModuleProcessorInterface
{
    use DataloadQueryArgsSchemaFilterInputModuleProcessorTrait;

    public const ENUM_MODERATED_CUSTOM_POST_STATUS = 'ModeratedCustomPostStatus';
    public const ENUM_UNMODERATED_CUSTOM_POST_STATUS = 'UnmoderatedCustomPostStatus';

    public const MODULE_FILTERINPUT_MODERATEDPOSTSTATUS = 'filterinput-moderatedpoststatus';
    public const MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS = 'filterinput-unmoderatedpoststatus';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS],
            [self::class, self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS],
        );
    }

    public function getFilterInput(array $module): ?array
    {
        $filterInputs = [
            self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS => [PoP_Module_Processor_MultiSelectFilterInputProcessor::class, PoP_Module_Processor_MultiSelectFilterInputProcessor::FILTERINPUT_MODERATEDPOSTSTATUS],
            self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS => [PoP_Module_Processor_MultiSelectFilterInputProcessor::class, PoP_Module_Processor_MultiSelectFilterInputProcessor::FILTERINPUT_UNMODERATEDPOSTSTATUS],
        ];
        return $filterInputs[$module[1]];
    }

    // public function isFiltercomponent(array $module)
    // {
    //     switch ($module[1]) {
    //         case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
    //         case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
    //             return true;
    //     }

    //     return parent::isFiltercomponent($module);
    // }

    public function getLabelText(array $module, array &$props)
    {
        switch ($module[1]) {
            case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
            case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
                return TranslationAPIFacade::getInstance()->__('Status', 'pop-coreprocessors');
        }

        return parent::getLabelText($module, $props);
    }

    public function getInputClass(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
                return GD_FormInput_ModeratedStatus::class;

            case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
                return GD_FormInput_UnmoderatedStatus::class;
        }

        return parent::getInputClass($module);
    }

    public function getName(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
            case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
                // Add a nice name, so that the URL params when filtering make sense
                return 'status';
        }

        return parent::getName($module);
    }

    public function getSchemaFilterInputType(array $module): ?string
    {
        $types = [
            self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ENUM),
            self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS => TypeCastingHelpers::makeArray(SchemaDefinition::TYPE_ENUM),
        ];
        return $types[$module[1]];
    }

    public function getSchemaFilterInputDescription(array $module): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS => $translationAPI->__('', ''),
            self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS => $translationAPI->__('', ''),
        ];
        return $descriptions[$module[1]];
    }

    protected function modifyFilterSchemaDefinitionItems(array &$schemaDefinitionItems, array $module)
    {
        switch ($module[1]) {
            case self::MODULE_FILTERINPUT_MODERATEDPOSTSTATUS:
                $schemaDefinitionItems[SchemaDefinition::ARGNAME_ENUMNAME] = self::ENUM_MODERATED_CUSTOM_POST_STATUS;
                $schemaDefinitionItems[SchemaDefinition::ARGNAME_ENUMVALUES] = SchemaHelpers::convertToSchemaFieldArgEnumValueDefinitions(
                    array_keys((new GD_FormInput_ModeratedStatus())->getAllValues())
                );
                break;
            case self::MODULE_FILTERINPUT_UNMODERATEDPOSTSTATUS:
                $schemaDefinitionItems[SchemaDefinition::ARGNAME_ENUMNAME] = self::ENUM_UNMODERATED_CUSTOM_POST_STATUS;
                $schemaDefinitionItems[SchemaDefinition::ARGNAME_ENUMVALUES] = SchemaHelpers::convertToSchemaFieldArgEnumValueDefinitions(
                    array_keys((new GD_FormInput_UnmoderatedStatus())->getAllValues())
                );
                break;
        }
    }
}



