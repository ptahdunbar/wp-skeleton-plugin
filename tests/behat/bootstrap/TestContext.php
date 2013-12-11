<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext
;

use Behat\Behat\Exception\PendingException,
    Behat\Behat\Exception\BehaviorException
;

use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\MinkDictionary;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode
;

class TestContext extends BehatContext
{
    protected $output = '';

    /**
     * @When /^I run `([^"]*)`$/
     */
    public function iRunBehatCommand($command)
    {
        $this->output = shell_exec("$command");
    }

    /**
     * @Then /^I should see "([^"]*)", "([^"]*)", and "([^"]*)"$/
     */
    public function iShouldSeeStringOutput($arg1, $arg2, $arg3)
    {
        foreach ([$arg1, $arg2, $arg3] as $arg) {
            assertContains($arg, $this->output, sprintf('%s not found in output', $arg));
        }
    }
}