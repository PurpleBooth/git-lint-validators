<?php

declare(strict_types=1);

/*
 * Copyright (C) 2016 Billie Thompson
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace PurpleBooth\GitLintValidators;

use PurpleBooth\GitLintValidators\Validator\CapitalizeTheSubjectLineValidator;
use PurpleBooth\GitLintValidators\Validator\DoNotEndTheSubjectLineWithAPeriodValidator;
use PurpleBooth\GitLintValidators\Validator\LimitTheBodyWrapLengthTo72CharactersValidator;
use PurpleBooth\GitLintValidators\Validator\LimitTheTitleLengthTo69CharactersValidator;
use PurpleBooth\GitLintValidators\Validator\SeparateSubjectFromBodyWithABlankLineValidator;
use PurpleBooth\GitLintValidators\Validator\SoftLimitTheTitleLengthTo50CharactersValidator;

/**
 * Build a ready ValidateMessage.
 */
class ValidatorFactoryImplementation implements ValidatorFactory
{
    /**
     * Get a message validator set-up with all the validators.
     *
     * @return ValidateMessage
     */
    public function getMessageValidator() : ValidateMessage
    {
        $messageValidator = new ValidateMessageImplementation(
            [
                new CapitalizeTheSubjectLineValidator(),
                new DoNotEndTheSubjectLineWithAPeriodValidator(),
                new LimitTheBodyWrapLengthTo72CharactersValidator(),
                new LimitTheTitleLengthTo69CharactersValidator(),
                new SeparateSubjectFromBodyWithABlankLineValidator(),
                new SoftLimitTheTitleLengthTo50CharactersValidator(),
            ]
        );

        return $messageValidator;
    }
}
