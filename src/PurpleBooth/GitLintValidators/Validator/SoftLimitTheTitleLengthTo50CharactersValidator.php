<?php

declare(strict_types=1);

namespace PurpleBooth\GitLintValidators\Validator;

use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\SoftLimitTheTitleLengthTo50CharactersStatus;

/**
 * This validator will check the subject is not longer than 50 characters.
 *
 * @see     SoftLimitTheTitleLengthTo50CharactersStatus
 */
class SoftLimitTheTitleLengthTo50CharactersValidator implements Validator
{
    const CHARACTER_LIMIT = 50;

    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't.
     *
     * @param Message $message
     */
    public function validate(Message $message)
    {
        if ($message->getTitleLength() > self::CHARACTER_LIMIT) {
            $message->addStatus(new SoftLimitTheTitleLengthTo50CharactersStatus());
        }
    }
}
