Feature: Testing Behat
  In order verify that behat is installed and configured properly.
  As a web developer
  I need to be able to run the behat command line utility and see results.

  Scenario: Display behat help
    When I run `vendor/bin/behat --help`
    Then I should see "Usage", "Arguments", and "Options"

  Scenario: Get a list of default phrases
    When I run `vendor/bin/behat -dl`
    Then I should see "Given", "When", and "Then"