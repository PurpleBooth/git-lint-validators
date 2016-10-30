<?php

declare(strict_types=1);

/*
 * Copyright (C) 2016 Billie Thompson
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace PurpleBooth\GitLintValidators\Validator;

use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\LimitTheTitleLengthTo69CharactersStatus;

/**
 * This validator will check the title length is at most 69 characters long.
 *
 * @see     LimitTheTitleLengthTo69CharactersStatus
 */
class LimitTheTitleLengthTo69CharactersValidator implements Validator
{
    const CHARACTER_LIMIT = 69;

    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't.
     *
     * @param Message $message
     */
    public function validate(Message $message)
    {
        if ($message->getTitleLength() > self::CHARACTER_LIMIT) {
            $message->addStatus(new LimitTheTitleLengthTo69CharactersStatus());
        }
    }
}
