<?php

abstract class GD_DataLoad_ActionExecuter_UpdateUserMetaValue_Tag extends GD_DataLoad_ActionExecuter_UpdateUserMetaValue
{
    protected function getRequestKey()
    {
        return POP_INPUTNAME_TAGID;
    }
}
