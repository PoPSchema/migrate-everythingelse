<?php
$class = (new class() extends \PoP\Root\Component\AbstractComponent
{
    /**
     * Boot component
     *
     * @return void
     */
    public static function beforeBoot()
    {
        parent::beforeBoot();

        // Initialize code
        require_once 'migrate/pop-everythingelse.php';
    }
});
$class::init();
