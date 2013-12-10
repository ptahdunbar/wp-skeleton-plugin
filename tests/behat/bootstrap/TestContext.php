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

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

class TestContext extends BehatContext
{
    protected $output;

    /**
     * @When /^I run `behat ([^"]*)`$/
     */
    public function iRunBehatHelp($arg1)
    {
        exec("./vendor/bin/behat {$arg1}", $this->output);

        $this->output = implode(' ', $this->output);
    }

    /**
     * @Then /^I should see "([^"]*)", "([^"]*)", and "([^"]*)"$/
     */
    public function iShouldSeeUsageArgumentsAnd($arg1, $arg2, $arg3)
    {
        foreach ([$arg1, $arg2, $arg3] as $arg) {
            assertContains($arg, $this->output, sprintf('%s not found in output', $arg));
        }
    }

    /**
     * @Then /^I should see "([^"]*)" skipped scenarios$/
     */
    public function iShouldSeeSkippedScenarios($count)
    {
        assertContains(
            "{$count} scenarios ({$count} skipped)",
            $this->output,
            sprintf('Invalid skipped scenerios. Should only skip %s.', $count)
        );
    }
}