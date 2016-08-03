<?php

namespace spec\PurpleBooth\GitLintValidators;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\MessageImplementation;
use PurpleBooth\GitLintValidators\Status\Status;

class MessageImplementationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

This is a message body. This is another part of the body.
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->shouldHaveType(MessageImplementation::class);
        $this->shouldHaveType(Message::class);
    }

    function it_can_tell_me_the_title_length()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

This is a message body. This is another part of the body.
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->getTitleLength()->shouldReturn(24);
    }

    function it_can_tell_me_if_the_title_is_capitalized()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

This is a message body. This is another part of the body.
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->isTitleCapitalised()->shouldReturn(true);
    }

    function it_can_tell_me_if_the_title_is_not_capitalized()
    {
        $commitMessage
            = <<<COMMIT
this is an example title

This is a message body. This is another part of the body.
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->isTitleCapitalised()->shouldReturn(false);
    }


    function it_can_tell_me_if_the_title_does_not_have_a_period_at_the_end()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

This is a message body. This is another part of the body.
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->hasTitleAFullStop()->shouldReturn(false);
    }

    function it_can_tell_me_if_the_title_has_a_period_at_the_end()
    {
        $commitMessage
            = <<<COMMIT
This is an example title.

This is a message body. This is another part of the body.
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->hasTitleAFullStop()->shouldReturn(true);
    }

    function it_can_tell_me_if_there_is_a_gap_after_the_title()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

This is a message body. This is another part of the body.

This is a message body. 
This is a message body. This is another part of the body.
This is a message
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->hasBlankLineAfterTitle()->shouldReturn(true);
    }

    function it_can_tell_me_if_there_not_is_a_gap_after_the_title()
    {
        $commitMessage
            = <<<COMMIT
This is an example title
This is a message body. This is another part of the body.
This is a message body. 
This is a message body. This is another part of the body.
This is a message
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->hasBlankLineAfterTitle()->shouldReturn(false);
    }

    function it_will_tell_me_the_body_wrap_length()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

This is a message body. This is another part of the body.

This is a message body. 
This is a message body. This is another part of the
This is a message
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->getBodyWrapLength()->shouldReturn(57);
    }

    function it_can_tell_you_if_it_has_not_got_a_body()
    {
        $commitMessage
            = <<<COMMIT
This is an example title




COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->hasABody()->shouldReturn(false);
    }

    function it_can_tell_you_if_it_has_got_a_body()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

Something
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->hasABody()->shouldReturn(true);
    }

    function it_can_tell_you_how_many_statuses_it_has(Status $status1, Status $status2)
    {
        $commitMessage
            = <<<COMMIT
This is an example title

Something
COMMIT;

        $this->beConstructedWith($commitMessage);
        $this->addStatus($status1);
        $this->addStatus($status2);
        $this->getStatusCount()->shouldReturn(2);
    }
}
