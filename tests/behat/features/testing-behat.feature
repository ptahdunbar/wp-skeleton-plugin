Feature: Testing Behat
  In order verify that behat is installed and configured properly.
  As a web developer
  I need to be able to run the behat command line utility and see results.

  Scenario: Display behat help
    When I run `behat --help`
    Then I should see "Usage", "Arguments", and "Options"

  Scenario: Dry run
    When I run `behat --dry-run`
    Then I should see "2" skipped scenarios
