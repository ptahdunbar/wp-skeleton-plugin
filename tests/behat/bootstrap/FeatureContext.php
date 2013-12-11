<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext
;

use Behat\Behat\Exception\PendingException;

use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\MinkDictionary;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode
;

require_once 'vendor/autoload.php';

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

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
}