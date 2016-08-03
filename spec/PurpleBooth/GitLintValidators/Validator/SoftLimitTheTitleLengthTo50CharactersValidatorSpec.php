<?php

namespace spec\PurpleBooth\GitLintValidators\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\SoftLimitTheTitleLengthTo50CharactersStatus;
use PurpleBooth\GitLintValidators\Validator\SoftLimitTheTitleLengthTo50CharactersValidator;
use PurpleBooth\GitLintValidators\Validator\Validator;

class SoftLimitTheTitleLengthTo50CharactersValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SoftLimitTheTitleLengthTo50CharactersValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }

    function it_does_not_set_a_status_if_everything_is_fine(Message $message)
    {
        $message->getTitleLength()->willReturn(50);
        $message->addStatus(Argument::any())->shouldNotBeCalled();
        $this->validate($message);
    }

    function it_returns_the_failure_status_when_it_is_greater_than_50_characters(Message $message)
    {
        $message->getTitleLength()->willReturn(51);
        $message->addStatus(Argument::type(SoftLimitTheTitleLengthTo50CharactersStatus::class))
                ->shouldBeCalled();
        $this->validate($message);
    }
}
