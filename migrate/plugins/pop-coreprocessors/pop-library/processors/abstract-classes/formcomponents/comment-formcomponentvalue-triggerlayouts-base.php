<?php
use PoP\Comments\TypeDataResolvers\CommentTypeDataResolver;

abstract class PoP_Module_Processor_CommentTriggerLayoutFormComponentValuesBase extends PoP_Module_Processor_TriggerLayoutFormComponentValuesBase
{
    public function getTriggerTypeDataResolverClass(array $module)
    {
        return CommentTypeDataResolver::class;
    }
}
