<?php

namespace spec\PurpleBooth\GitLintValidators\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\SeparateSubjectFromBodyWithABlankLineStatus;
use PurpleBooth\GitLintValidators\Validator\SeparateSubjectFromBodyWithABlankLineValidator;
use PurpleBooth\GitLintValidators\Validator\Validator;

class SeparateSubjectFromBodyWithABlankLineValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SeparateSubjectFromBodyWithABlankLineValidator::class);
    }


    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }


    function it_returns_the_success_status_when_there_is_a_blank_line_after_the_title(Message $message)
    {
        $message->hasBlankLineAfterTitle()->willReturn(true);
        $message->addStatus(Argument::any())
                ->shouldNotBeCalled();
        $this->validate($message);
    }

    function it_returns_the_failure_status_when_there_is_not_a_blank_line_after_the_title(Message $message)
    {
        $message->hasBlankLineAfterTitle()->willReturn(false);
        $message->addStatus(Argument::type(SeparateSubjectFromBodyWithABlankLineStatus::class))
                ->shouldBeCalled();
        $this->validate($message);
    }
}
