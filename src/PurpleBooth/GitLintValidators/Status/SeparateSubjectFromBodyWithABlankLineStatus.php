<?php

declare(strict_types=1);

namespace PurpleBooth\GitLintValidators\Status;

use PurpleBooth\GitLintValidators\Validator\SeparateSubjectFromBodyWithABlankLineValidator;

/**
 * This is the status returned when the SeparateSubjectFromBodyWithABlankLineValidator identifies a problem.
 *
 * @see     SeparateSubjectFromBodyWithABlankLineValidator
 */
class SeparateSubjectFromBodyWithABlankLineStatus implements Status
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
        return 'Please put a single blank line between the subject and body of the commit message';
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
        return 'http://chris.beams.io/posts/git-commit/#separate';
    }
}
