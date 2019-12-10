<?php

class PoP_Events_API_Base
{
    public function __construct()
    {
        PoP_Events_APIFactory::setInstance($this);
    }
}
