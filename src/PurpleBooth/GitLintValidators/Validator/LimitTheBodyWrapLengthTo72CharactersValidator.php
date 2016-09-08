<?php

declare(strict_types=1);

namespace PurpleBooth\GitLintValidators\Validator;

use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\LimitTheBodyWrapLengthTo72CharactersStatus;

/**
 * This validator will check the body width is 72 characters wide at the most.
 *
 * @see     LimitTheBodyWrapLengthTo72CharactersStatus
 */
class LimitTheBodyWrapLengthTo72CharactersValidator implements Validator
{
    const WRAP_LIMIT = 72;

    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't.
     *
     * @param Message $message
     */
    public function validate(Message $message)
    {
        if ($message->getBodyWrapLength() > self::WRAP_LIMIT) {
            $message->addStatus(new LimitTheBodyWrapLengthTo72CharactersStatus());
        }
    }
}
