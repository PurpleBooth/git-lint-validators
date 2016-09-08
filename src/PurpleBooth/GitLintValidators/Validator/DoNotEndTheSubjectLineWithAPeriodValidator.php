<?php

declare(strict_types=1);

namespace PurpleBooth\GitLintValidators\Validator;

use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\DoNotEndTheSubjectLineWithAPeriodStatus;

/**
 * This validator will check if the subject line does not have a full stop at the end.
 *
 * @see     DoNotEndTheSubjectLineWithAPeriodStatus
 */
class DoNotEndTheSubjectLineWithAPeriodValidator implements Validator
{
    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't.
     *
     * @param Message $message
     */
    public function validate(Message $message)
    {
        if ($message->hasTitleAFullStop()) {
            $message->addStatus(new DoNotEndTheSubjectLineWithAPeriodStatus());
        }
    }
}
