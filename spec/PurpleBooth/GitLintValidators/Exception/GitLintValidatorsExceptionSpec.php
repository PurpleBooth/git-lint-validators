<?php

namespace spec\PurpleBooth\GitLintValidators\Exception;

use Exception;
use PhpSpec\ObjectBehavior;
use PurpleBooth\GitLintValidators\Exception\GitLintValidatorsException;

class GitLintValidatorsExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GitLintValidatorsException::class);
        $this->shouldHaveType(Exception::class);
    }
}
