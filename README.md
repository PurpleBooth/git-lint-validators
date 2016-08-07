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

You can try out this library by using it as a [git commit hook].

[git commit hook]: https://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks

#### Usage

Edit `.git/hooks/commit-msg` to look like this (and make it executable).

```
#!/bin/sh

bin/git-lint-validators git-lint-validator:hook $1
```

It's fairly customisable too, here are some options:

```
$ bin/git-lint-validators help git-lint-validator:hook
Usage:
  git-lint-validator:hook [options] [--] <commit-message-file>

Arguments:
  commit-message-file                Path to commit message file

Options:
  -i, --ignore[=IGNORE]              Ignore a commit message that matches this pattern and don't test it [default: ["/^Merge branch/"]] (multiple values allowed)
  -c, --comment-char[=COMMENT-CHAR]  Ignore lines that are prefixed with this character [default: "#"]
  -h, --help                         Display this help message
  -q, --quiet                        Do not output any message
  -V, --version                      Display this application version
      --ansi                         Force ANSI output
      --no-ansi                      Disable ANSI output
  -n, --no-interaction               Do not ask any interactive question
  -v|vv|vvv, --verbose               Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
 Check your commit messages to ensure they follow the guidelines
 in your add this to your .git/hooks/commit-msg file


 Here are some good articles on commit message style:

 * http://chris.beams.io/posts/git-commit/
 * https://git-scm.com/book/ch5-2.html#Commit-Guidelines
 * https://github.com/blog/926-shiny-new-commit-styles


```

#### Output While Running

```bash

$ git commit --am


 [ERROR] Incorrectly formatted commit message


 * Please capitalise the subject line of the commit message (http://chris.beams.io/posts/git-commit/#capitalize)

```

### Library

You can use the whole library

```
$validatorFactory = new ValidatorFactoryImplementation();
$validators       = $validatorFactory->getMessageValidator();


$message
    = <<<MESSAGE
This is an example title

This is a message body. This is another part of the body.
MESSAGE;

$exampleMessage = new MessageImplementation("exampleSha", $message);

$validators->validate($exampleMessage);
// -> Message Object will now have a Status objects set on them

```

Alternatively you could use the validators alone

```php
<?php

new ValidateMessageImplementation(
    [
        new CapitalizeTheSubjectLineValidator(),
        new DoNotEndTheSubjectLineWithAPeriodValidator(),
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
