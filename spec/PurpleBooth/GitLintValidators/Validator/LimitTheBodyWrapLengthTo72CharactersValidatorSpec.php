<?php

namespace spec\PurpleBooth\GitLintValidators\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\LimitTheBodyWrapLengthTo72CharactersStatus;
use PurpleBooth\GitLintValidators\Validator\LimitTheBodyWrapLengthTo72CharactersValidator;
use PurpleBooth\GitLintValidators\Validator\Validator;

class LimitTheBodyWrapLengthTo72CharactersValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LimitTheBodyWrapLengthTo72CharactersValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }


    function it_returns_the_success_status_when_the_body_wrap_is_equal_to_or_less_than_72(Message $message)
    {
        $message->getBodyWrapLength()->willReturn(72);
        $message->addStatus(Argument::any())
                ->shouldNotBeCalled();
        $this->validate($message);
    }

    function it_returns_the_failure_status_when_the_body_wrap_is_greater_than_72(Message $message)
    {
        $message->getBodyWrapLength()->willReturn(73);
        $message->addStatus(Argument::type(LimitTheBodyWrapLengthTo72CharactersStatus::class))
                ->shouldBeCalled();
        $this->validate($message);
    }
}
