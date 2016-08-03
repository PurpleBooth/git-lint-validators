<?php

declare(strict_types = 1);

namespace PurpleBooth\GitLintValidators;

use PurpleBooth\GitLintValidators\Validator\CapitalizeTheSubjectLineValidator;
use PurpleBooth\GitLintValidators\Validator\DoNotEndTheSubjectLineWithAPeriodValidator;
use PurpleBooth\GitLintValidators\Validator\LimitTheBodyWrapLengthTo72CharactersValidator;
use PurpleBooth\GitLintValidators\Validator\LimitTheTitleLengthTo69CharactersValidator;
use PurpleBooth\GitLintValidators\Validator\SeparateSubjectFromBodyWithABlankLineValidator;
use PurpleBooth\GitLintValidators\Validator\SoftLimitTheTitleLengthTo50CharactersValidator;

/**
 * Build a ready ValidateMessage
 *
 * @package PurpleBooth\GitLintValidators
 */
class ValidatorFactoryImplementation implements ValidatorFactory
{
    /**
     * Get a message validator set-up with all the validators
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
