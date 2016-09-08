<?php

declare(strict_types=1);

namespace PurpleBooth\GitLintValidators;

/**
 * Build a ready ValidateMessage.
 */
interface ValidatorFactory
{
    /**
     * Get a message validator set-up with all the validators.
     *
     * @return ValidateMessage
     */
    public function getMessageValidator() : ValidateMessage;
}
