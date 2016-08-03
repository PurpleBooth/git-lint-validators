<?php

namespace spec\PurpleBooth\GitLintValidators\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\LimitTheTitleLengthTo69CharactersStatus;
use PurpleBooth\GitLintValidators\Validator\LimitTheTitleLengthTo69CharactersValidator;
use PurpleBooth\GitLintValidators\Validator\Validator;

class LimitTheTitleLengthTo69CharactersValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LimitTheTitleLengthTo69CharactersValidator::class);
    }


    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }


    function it_returns_the_success_status_when_the_title_length_is_less_than_or_equal_to_69(Message $message)
    {
        $message->getTitleLength()->willReturn(69);
        $message->addStatus(Argument::any())
                ->shouldNotBeCalled();
        $this->validate($message);
    }

    function it_returns_the_failure_status_when_the_title_length_is_greater_than_70(Message $message)
    {
        $message->getTitleLength()->willReturn(70);
        $message->addStatus(Argument::type(LimitTheTitleLengthTo69CharactersStatus::class))
                ->shouldBeCalled();
        $this->validate($message);
    }
}
