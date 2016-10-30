<?php

declare(strict_types=1);

/*
 * Copyright (C) 2016 Billie Thompson
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace PurpleBooth\GitLintValidators;

use PurpleBooth\GitLintValidators\Validator\Validator;

/**
 * Validate against a number of validators against a message.
 */
class ValidateMessageImplementation implements ValidateMessage
{
    /**
     * @var array
     */
    private $validators;

    /**
     * ValidationServiceImplementation constructor.
     *
     * @param array $validators
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;

        if (count($validators) < 1) {
            new \LogicException('You need to provide the validation service with at least 1 validator');
        }
    }

    /**
     * Test a message against a number of validators.
     *
     * @param Message $message
     */
    public function validate(Message $message)
    {
        /** @var Validator $validator */
        foreach ($this->validators as $validator) {
            $validator->validate($message);
        }
    }
}
