<?php

declare(strict_types=1);

namespace PurpleBooth\GitLintValidators\Status;

use PurpleBooth\GitLintValidators\Validator\DoNotEndTheSubjectLineWithAPeriodValidator;

/**
 * This is the status returned when the DoNotEndTheSubjectLineWithAPeriodValidator identifies a problem.
 *
 * @see     DoNotEndTheSubjectLineWithAPeriodValidator
 */
class DoNotEndTheSubjectLineWithAPeriodStatus implements Status
{
    /**
     * Get the importance of this status.
     *
     * The lower the value the less important it is, the higher the more important.
     *
     * @return int
     */
    public function getWeight() : int
    {
        return Status::WEIGHT_ERROR;
    }

    /**
     * A human readable message that describes this state.
     *
     * This will be displayed to the user via the GitHub state
     *
     * @return string
     */
    public function getMessage() : string
    {
        return 'Please remove the full stop at the end of the subject line of the commit message';
    }

    /**
     * Is true if the status is one that should not be taken as indicative of a incorrectly formatted message.
     *
     * @return bool
     */
    public function isPositive() : bool
    {
        return false;
    }

    /**
     * Get a URL with further explanation about this commit message status.
     *
     * @return string
     */
    public function getDetailsUrl() : string
    {
        return 'http://chris.beams.io/posts/git-commit/#end';
    }
}
