<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext
;

use Behat\Behat\Exception\PendingException;
use Behat\Behat\Event\SuiteEvent;

use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\MinkDictionary;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode
;

/**
 * Require 3rd-party libraries here:
 */

// Composer
include_once 'vendor/autoload.php';

// PHPUnit Assertion functions
include_once 'PHPUnit/Autoload.php';
include_once 'PHPUnit/Framework/Assert/Functions.php';

// Bootstrap the WordPress environment.
include_once 'tests/bootstrap.php';

class FeatureContext extends BehatContext
{
    use MinkDictionary;

    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     *
     * @return void
     */
    public function __construct(array $parameters)
    {
        $this->useContext('test', new TestContext($parameters));
    }

//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//
}