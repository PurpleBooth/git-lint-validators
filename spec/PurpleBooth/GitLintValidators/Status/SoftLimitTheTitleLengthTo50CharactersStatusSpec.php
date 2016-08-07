<?php

namespace spec\PurpleBooth\GitLintValidators\Status;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitLintValidators\Status\SoftLimitTheTitleLengthTo50CharactersStatus;
use PurpleBooth\GitLintValidators\Status\Status;

class SoftLimitTheTitleLengthTo50CharactersStatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SoftLimitTheTitleLengthTo50CharactersStatus::class);
    }

    function it_has_weight_50()
    {
        $this->getWeight()->shouldReturn(50);
    }

    function it_has_message()
    {
        $this->getMessage()->shouldReturn(
            'Looks good, but can you shorten the subject of the commit message to 50 characters or less?'
        );
    }

    function it_is_a_status()
    {
        $this->shouldImplement(Status::class);
    }


    function it_is_a_good_status()
    {
        $this->isPositive()->shouldReturn(true);
    }

    function it_should_provide_a_descriptive_url()
    {
        $this->getDetailsUrl()->shouldReturn("http://chris.beams.io/posts/git-commit/#limit-50");
    }
}
