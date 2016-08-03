<?php

namespace spec\PurpleBooth\GitLintValidators\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\CapitalizeTheSubjectLineStatus;
use PurpleBooth\GitLintValidators\Status\SuccessStatus;
use PurpleBooth\GitLintValidators\Validator\CapitalizeTheSubjectLineValidator;
use PurpleBooth\GitLintValidators\Validator\Validator;

class CapitalizeTheSubjectLineValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CapitalizeTheSubjectLineValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }

    function it_returns_the_success_status_when_title_is_capitalised(Message $message)
    {
        $message->isTitleCapitalised()->willReturn(true);

        $message->addStatus(Argument::any())
                ->shouldNotBeCalled();
        $this->validate($message);
    }

    function it_returns_the_failure_status_when_the_title_is_not_capitalised(Message $message)
    {
        $message->isTitleCapitalised()->willReturn(false);
        $message->addStatus(Argument::type(CapitalizeTheSubjectLineStatus::class))
                ->shouldBeCalled();
        $this->validate($message);
    }
}
