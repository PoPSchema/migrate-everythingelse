<?php

class PoPCore_Dataload_CheckpointProcessor extends \PoP\ComponentModel\CheckpointProcessorBase
{
    public const CHECKPOINT_PROFILEACCESS = 'checkpoint-profileaccess';
    public const CHECKPOINT_PROFILEACCESS_SUBMIT = 'checkpoint-profileaccess-submit';

    public function getCheckpointsToProcess()
    {
        return array(
            [self::class, self::CHECKPOINT_PROFILEACCESS],
            [self::class, self::CHECKPOINT_PROFILEACCESS_SUBMIT],
        );
    }

    public function process(array $checkpoint)
    {
        switch ($checkpoint[1]) {
            case self::CHECKPOINT_PROFILEACCESS:
                // Check if the user has Profile Access: access to add/edit content
                if (!userHasProfileAccess()) {
                    return new \PoP\ComponentModel\Error('usernoprofileaccess');
                }
                break;

            case self::CHECKPOINT_PROFILEACCESS_SUBMIT:
                // Check if the user has Profile Access: access to add/edit content
                if (!doingPost()) {
                    return new \PoP\ComponentModel\Error('notdoingpost');
                }

                if (!userHasProfileAccess()) {
                    return new \PoP\ComponentModel\Error('usernoprofileaccess');
                }
                break;
        }
    
        return parent::process($checkpoint);
    }
}

