<?php

namespace spec\PurpleBooth\GitLintValidators;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitLintValidators\ValidateMessage;
use PurpleBooth\GitLintValidators\ValidatorFactory;
use PurpleBooth\GitLintValidators\ValidatorFactoryImplementation;

class ValidatorFactoryImplementationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ValidatorFactoryImplementation::class);
        $this->shouldImplement(ValidatorFactory::class);
    }

    function it_is_able_to_build_the_latest_factory()
    {
        $this->getMessageValidator()->shouldHaveType(ValidateMessage::class);
    }
}
