<?php

class ExampleTest extends WP_UnitTestCase
{
    /**
     * @dataProvider getRequiredPluginsProvider
     */
    public function testRequiredPluginsAreActive($plugin)
    {
        $this->assertTrue( is_plugin_active($plugin), sprintf('%s is not activated.', $plugin) );
    }

    /**
     * @dataProvider getRequiredOptionsProvider
     */
    public function testRequiredWPOptionsAreSet($option_name, $option_value)
    {
        $this->assertSame($option_value, get_option($option_name));
    }

    /**
     * @see testAllRequiredPluginsAreActive
     * @return array
     */
    public function getRequiredPluginsProvider()
    {
        return [
            ['wp-skeleton-plugin/autoload.php'],
        ];
    }

    /**
     * @see testRequiredWPOptionsAreSet
     * @return array
     */
    function getRequiredOptionsProvider()
    {
        return [
            ['timezone_string', 'America/New_York'],
        ];
    }
}