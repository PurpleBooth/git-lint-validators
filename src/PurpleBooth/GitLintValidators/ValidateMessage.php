<?php

declare(strict_types=1);

/*
 * Copyright (C) 2016 Billie Thompson
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace PurpleBooth\GitLintValidators;

/**
 * Validate against a number of validators against a message.
 */
interface ValidateMessage
{
    /**
     * Test a message against a number of validators.
     *
     * @param Message $message
     */
    public function validate(Message $message);
}
