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
use PurpleBooth\GitLintValidators\Status\CapitalizeTheSubjectLineStatus;

/**
 * This validator will check if the subject line is capitalised in the message.
 *
 * @see     CapitalizeTheSubjectLineStatus
 */
class CapitalizeTheSubjectLineValidator implements Validator
{
    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't.
     *
     * @param Message $message
     */
    public function validate(Message $message)
    {
        if (!$message->isTitleCapitalised()) {
            $message->addStatus(new CapitalizeTheSubjectLineStatus());
        }
    }
}
