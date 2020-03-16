<?php
$class = (new class() extends \PoP\Root\Component\AbstractComponent
{
    /**
     * Boot component
     *
     * @return void
     */
    public static function prematureBoot()
    {
        parent::prematureBoot();

        // Initialize code
        require_once 'migrate/pop-everythingelse.php';
    }
});
$class::init();
