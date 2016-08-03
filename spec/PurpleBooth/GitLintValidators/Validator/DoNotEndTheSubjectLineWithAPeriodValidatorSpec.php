<?php

namespace spec\PurpleBooth\GitLintValidators\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\DoNotEndTheSubjectLineWithAPeriodStatus;
use PurpleBooth\GitLintValidators\Validator\DoNotEndTheSubjectLineWithAPeriodValidator;
use PurpleBooth\GitLintValidators\Validator\Validator;

class DoNotEndTheSubjectLineWithAPeriodValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DoNotEndTheSubjectLineWithAPeriodValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }

    function it_returns_the_success_status_when_the_title_has_no_full_stop(Message $message)
    {
        $message->hasTitleAFullStop()->willReturn(false);
        $message->addStatus(Argument::any())
                ->shouldNotBeCalled();
        $this->validate($message);
    }

    function it_returns_the_failure_status_when_the_title_has_a_full_stop(Message $message)
    {
        $message->hasTitleAFullStop()->willReturn(true);
        $message->addStatus(Argument::type(DoNotEndTheSubjectLineWithAPeriodStatus::class))
                ->shouldBeCalled();
        $this->validate($message);
    }
}
