<?php

declare(strict_types=1);

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
