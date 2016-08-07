<?php

namespace spec\PurpleBooth\GitLintValidators\Status;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitLintValidators\Status\CapitalizeTheSubjectLineStatus;
use PurpleBooth\GitLintValidators\Status\Status;

class CapitalizeTheSubjectLineStatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CapitalizeTheSubjectLineStatus::class);
    }

    function it_has_weight_100()
    {
        $this->getWeight()->shouldReturn(100);
    }

    function it_has_message()
    {
        $this->getMessage()->shouldReturn('Please capitalise the subject line of the commit message');
    }

    function it_is_a_good_status()
    {
        $this->isPositive()->shouldReturn(false);
    }

    function it_is_a_status()
    {
        $this->shouldImplement(Status::class);
    }

    function it_should_provide_a_descriptive_url()
    {
        $this->getDetailsUrl()->shouldReturn("http://chris.beams.io/posts/git-commit/#capitalize");
    }
}
