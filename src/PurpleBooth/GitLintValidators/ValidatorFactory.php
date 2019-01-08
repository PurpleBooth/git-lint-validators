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
 * Build a ready ValidateMessage.
 */
interface ValidatorFactory
{
    /**
     * Get a message validator set-up with all the validators.
     *
     * @return ValidateMessage
     */
    public function getMessageValidator(): ValidateMessage;
}
