<?php
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\Engine\Route\RouteUtils;

class GD_URE_Module_Processor_UserTypeaheadComponentFormInputs extends PoP_Module_Processor_UserTypeaheadComponentFormInputs
{
    public const MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITY = 'ure-typeahead-component-community';
    public const MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITYPLUSMEMBERS = 'ure-typeahead-component-communityplusmembers';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITY],
            [self::class, self::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITYPLUSMEMBERS],
        );
    }

    public function getLabelText(array $module, array &$props)
    {
        switch ($module[1]) {
            case self::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITY:
                return TranslationAPIFacade::getInstance()->__('Communities', 'ure-popprocessors');
        }

        return parent::getLabelText($module, $props);
    }

    protected function getTypeaheadDataloadSource(array $module, array &$props)
    {
        $cmsusersapi = \PoP\Users\FunctionAPIFactory::getInstance();
        switch ($module[1]) {
            case self::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITYPLUSMEMBERS:
                $vars = \PoP\ComponentModel\Engine_Vars::getVars();
                $author = $vars['routing-state']['queried-object-id'];
                $url = $cmsusersapi->getUserURL($author);
                return \PoP\ComponentModel\Utils::addRoute($url, POP_USERCOMMUNITIES_ROUTE_COMMUNITYPLUSMEMBERS);

            case self::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITY:
                return RouteUtils::getRouteURL(POP_USERCOMMUNITIES_ROUTE_COMMUNITIES);
        }

        return parent::getTypeaheadDataloadSource($module, $props);
    }

    protected function getThumbprintQuery(array $module, array &$props)
    {
        $ret = parent::getThumbprintQuery($module, $props);

        switch ($module[1]) {
            case self::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITY:
                $ret['role'] = GD_URE_ROLE_COMMUNITY;
                break;
        }

        return $ret;
    }

    protected function getPendingMsg(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITY:
                return TranslationAPIFacade::getInstance()->__('Loading Communities', 'ure-popprocessors');
        }

        return parent::getPendingMsg($module);
    }

    protected function getNotfoundMsg(array $module)
    {
        switch ($module[1]) {
            case self::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITY:
                return TranslationAPIFacade::getInstance()->__('No Communities found', 'ure-popprocessors');
        }

        return parent::getNotfoundMsg($module);
    }
}



