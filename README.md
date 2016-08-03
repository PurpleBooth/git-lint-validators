# Git Lint

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PurpleBooth/git-lint-validators/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PurpleBooth/git-lint-validators/?branch=master)
[![Build Status](https://travis-ci.org/PurpleBooth/git-lint-validators.svg?branch=master)](https://travis-ci.org/PurpleBooth/git-lint-validators)
[![Dependency Status](https://www.versioneye.com/user/projects/57a26855447bcc004d5ec866/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/57a26855447bcc004d5ec866)
[![Latest Stable Version](https://poser.pugx.org/purplebooth/git-lint-validators/v/stable)](https://packagist.org/packages/purplebooth/git-lint-validators)
[![License](https://poser.pugx.org/purplebooth/git-lint-validators/license)](https://packagist.org/packages/purplebooth/git-lint-validators)

This project is designed to ensure that the commits you're making to a
repository follow the git coding style. This is simply the basic
validators.

The standard that they test for is [the one described by Chris Beams].

The validations it implements are:

* Separate subject from body with a blank line
* Limit the subject line to 50 characters (soft limit, hard limit at 69)
* Capitalize the subject line
* Do not end the subject line with a period
* Wrap the body at 72 characters

[the one described by Chris Beams]: http://chris.beams.io/posts/git-commit/

## Getting Started

### Prerequisities

You'll need to install:

 * PHP (Minimum 7.0)

### Installing

```bash

composer require PurpleBooth/git-lint-validators

```


## Usage

### Tool

You can try out this library by using it as a tool.

#### Usage

```

Billies-MacBook-Pro-2:git-github-lint billie$ bin/git-github-lint help git-github-lint:pr
Usage:
  git-github-lint:pr [options] [--] <github-username> <github-repository> <pull-request-id>

Arguments:
  github-username       GitHub Username
  github-repository     GitHub Repository
  pull-request-id       The ID of the pull request

Options:
  -t, --token=TOKEN     The token to authenticate to the API with.
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
 Evaluates a the commits in a pull request and checks that their messages match the style advised by Git. It will then update the "status" in github (that little dot next to the commits).


 Here are some good articles on commit message style:

 * http://chris.beams.io/posts/git-commit/
 * https://git-scm.com/book/ch5-2.html#Commit-Guidelines
 * https://github.com/blog/926-shiny-new-commit-styles


```

#### Output While Running

```bash

$ php vendor/bin/git-github-lint git-github-lint:pr \
                                 -t my-token \
                                 PurpleBooth \
                                 git-github-lint \
                                 3

git-github-lint:pr
==================

 // Analysing PR PurpleBooth/git-github-lint#3


 [OK] Finished!

```

You can look at the [pull requests on this repo] to see what the effect
is like in person.

[pull requests on this repo]: https://github.com/PurpleBooth/git-github-lint/pull/3

### Library

You can use the whole library

```php
<?php

$gitHubClient = new \Github\Client()

/** @var GitHubLint $gitHubLint **/
$gitHubLint = new GitHubLintImplementation($gitHubClient);
$gitHubLint->analyse('PurpleBooth', 'git-github-lint', 3);
// -> The commits on your PR should now be updated with a status
```

Alternatively you could use the validators alone

```php
<?php

new ValidateMessageImplementation(
    [
        new CapitalizeTheSubjectLineValidator(),
        new DoNotEndTheSubjectLineWithAPeriodValidator(),
        new LimitTheBodyWrapLengthTo72CharactersValidator(),
        new LimitTheTitleLengthTo69CharactersValidator(),
        new SeparateSubjectFromBodyWithABlankLineValidator(),
        new SoftLimitTheTitleLengthTo50CharactersValidator(),
    ]
);


$message
    = <<<MESSAGE
This is an example title

This is a message body. This is another part of the body.
MESSAGE;

$exampleMessage = new MessageImplementation("exampleSha", $message);

$messageValidator->validate($exampleMessage);
// -> Message Object will now have a Status objects set on them
```

Please depend on the interfaces rather than the concrete
implementations. Concrete implementations may change without causing a
BC break, interfaces changing will cause major version increment,
indicating a BC break.

## Running the tests

To run the tests for coding style

First checkout the library, then run

```bash
composer install
```

### Coding Style

We follow PSR2, and also enforce PHPDocs on all functions

```bash
vendor/bin/phpcs -p --standard=psr2 src/ spec/
```

### Unit tests

We use PHPSpec for unit tests

```bash
vendor/bin/phpspec run
```


## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code
of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions
available, see the [tags on this repository](https://github.com/purplebooth/git-lint-validators/tags).

## Authors

See the list of [contributors](https://github.com/purplebooth/git-lint-validators/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
