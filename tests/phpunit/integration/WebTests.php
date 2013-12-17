<?php

class WebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    public static $browsers = [
        [
            'name'    => 'Firefox',
            'browserName' => 'firefox',
            'host'    => 'localhost',
            'port'    => 4444,
            'timeout' => 30000,
        ],
//        [
//            'name'    => 'Chrome',
//            'browserName' => 'chrome',
//            'host'    => 'localhost',
//            'port'    => 4444,
//            'timeout' => 30000,
//        ],
//        [
//            'name'    => 'Safari',
//            'browserName' => 'safari',
//            'host'    => 'localhost',
//            'port'    => 4444,
//            'timeout' => 30000,
//        ],
//        [
//            'name'    => 'IE',
//            'browserName' => 'internet explorer',
//            'host'    => 'localhost',
//            'port'    => 4444,
//            'timeout' => 30000,
//        ]
    ];

    protected function setUp()
    {
        $this->setBrowserUrl('http://www.example.com/');
    }

    public function testTitle()
    {
        $this->url('http://www.example.com/');
        $this->assertEquals('Example Domain', $this->title());
    }
}