<?php

class AcceptanceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Returns an array of all required plugins that need to be active in
     * this WordPress installation.
     *
     * @see testAllRequiredPluginsAreActive
     */
    public function getRequiredPlugins()
    {
        return [
            ['hello.php'],
        ];
    }

    /**
     * @dataProvider getRequiredPlugins
     */
    public function testAllRequiredPluginsAreActive($plugin)
    {
        $this->assertTrue( is_plugin_active($plugin), sprintf('%s is not activated.', $plugin) );
    }
}