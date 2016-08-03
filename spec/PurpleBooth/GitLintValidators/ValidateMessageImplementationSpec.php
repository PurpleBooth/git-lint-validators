<?php

namespace spec\PurpleBooth\GitLintValidators;

use LogicException;
use PhpSpec\ObjectBehavior;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\ValidateMessage;
use PurpleBooth\GitLintValidators\ValidateMessageImplementation;
use PurpleBooth\GitLintValidators\Validator\Validator;

class ValidateMessageImplementationSpec extends ObjectBehavior
{
    function it_is_initializable(Validator $successValidator)
    {
        $this->beConstructedWith([$successValidator]);
        $this->shouldHaveType(ValidateMessageImplementation::class);
        $this->shouldHaveType(ValidateMessage::class);
    }

    function it_throws_an_exception_if_i_do_not_contruct_the_service_with_at_least_one_validator()
    {
        $this->shouldThrow(LogicException::class);
        $this->beConstructedWith([]);
        $this->shouldHaveType(ValidateMessageImplementation::class);
    }

    function it_will_validate_messages_against_all_validators(
        Message $message,
        Validator $successValidator,
        Validator $lowWeightValidator,
        Validator $highWeightValidator
    ) {
        $successValidator->validate($message)->shouldBeCalled();
        $lowWeightValidator->validate($message)->shouldBeCalled();
        $highWeightValidator->validate($message)->shouldBeCalled();

        $this->beConstructedWith([$successValidator, $highWeightValidator, $lowWeightValidator]);
        $this->validate($message);
    }
}
