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

/**
 * Checks if a message meets a specific rule, and returns a status appropriate for the test passing or not passing.
 */
interface Validator
{
    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't.
     *
     * @param Message $message
     */
    public function validate(Message $message);
}
