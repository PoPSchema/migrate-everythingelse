<?php

class GD_URE_Dataload_UserCheckpointProcessor extends \PoP\ComponentModel\CheckpointProcessorBase
{
    public const CHECKPOINT_LOGGEDINUSER_ISPROFILEORGANIZATION = 'checkpoint-loggedinuser-isprofileorganization';
    public const CHECKPOINT_LOGGEDINUSER_ISPROFILEINDIVIDUAL = 'checkpoint-loggedinuser-isprofileindividual';

    public function getCheckpointsToProcess()
    {
        return array(
            [self::class, self::CHECKPOINT_LOGGEDINUSER_ISPROFILEORGANIZATION],
            [self::class, self::CHECKPOINT_LOGGEDINUSER_ISPROFILEINDIVIDUAL],
        );
    }

    public function process(array $checkpoint)
    {
        $vars = \PoP\ComponentModel\Engine_Vars::getVars();
        $current_user_id = $vars['global-userstate']['current-user-id'];
        switch ($checkpoint[1]) {
            case self::CHECKPOINT_LOGGEDINUSER_ISPROFILEORGANIZATION:
                if (!gdUreIsOrganization($current_user_id)) {
                    return new \PoP\ComponentModel\Error('profilenotorganization');
                }
                break;

            case self::CHECKPOINT_LOGGEDINUSER_ISPROFILEINDIVIDUAL:
                if (!gdUreIsIndividual($current_user_id)) {
                    return new \PoP\ComponentModel\Error('profilenotindividual');
                }
                break;
        }
    
        return parent::process($checkpoint);
    }
}

