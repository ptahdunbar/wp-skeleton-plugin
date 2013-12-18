# WP Skeleton Plugin [![Build Status](https://travis-ci.org/ptahdunbar/wp-skeleton-plugin.png?branch=master)](https://travis-ci.org/ptahdunbar/wp-skeleton-plugin)

> "A Walking Skeleton is an implementation of the thinnest possible slice of real functionality that we can automatically build, deploy and test end-to-end." - Freeman & Pryce GOOS

**NOTE** This is a work in progress. Very alpha, subject to sweeping changes at random intervals :)

## Installation

### Via composer

#### Download into plugins directory:

```
{
    "require" : {
        "ptahdunbar/wp-skeleton-plugin" : "dev-master"
    }
}
```

#### Download into mu-plugins directory:

```
{
    "require" : {
        "ptahdunbar/wp-skeleton-plugin" : "dev-muplugin"
    }
}
```

## Features

* Supports [PHPUnit](http://phpunit.de/manual/) and [Behat](http://behat.org/) for automated testing.
* Supports [Travis CI](https://travis-ci.org/) for continuous integration.
* Supports [Phing](http://www.phing.info/) for task automation.
* Supports [Composer](http://getcomposer.org/) and [Bower](http://bower.io/) for vendoring dependencies.
* Supports [Github Updater](https://github.com/afragen/github-updater)
* Includes a `.pot` as a starting translation file.


#### Selenium Reference
* https://github.com/sebastianbergmann/phpunit-selenium/blob/master/Tests/Selenium2TestCaseTest.php
* https://code.google.com/p/selenium/wiki/FrequentlyAskedQuestions
* https://code.google.com/p/selenium/wiki/Grid2
* http://scipilot.org/blog/2013/06/30/re-learning-unit-testing-selenium-2-phpunit-selenium/