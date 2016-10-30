<?php

declare(strict_types=1);

/*
 * Copyright (C) 2016 Billie Thompson
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace PurpleBooth\GitLintValidators\Status;

/**
 * The state that a validator detected the message was in.
 */
interface Status
{
    const WEIGHT_ERROR = 100;
    const WEIGHT_WARN = 50;
    const WEIGHT_OTHER_ERRORS = 25;
    const WEIGHT_SUCCESS = 0;

    const STATE_SUCCESS = 'success';
    const STATE_FAILURE = 'failure';

    /**
     * Get the importance of this status.
     *
     * The lower the value the less important it is, the higher the more important.
     *
     * @return int
     */
    public function getWeight() : int;

    /**
     * Is true if the status is one that should not be taken as indicative of a incorrectly formatted message.
     *
     * @return bool
     */
    public function isPositive() : bool;

    /**
     * A human readable message that describes this state.
     *
     * This will be displayed to the user via the GitHub state
     *
     * @return string
     */
    public function getMessage() : string;

    /**
     * Get a URL with further explanation about this commit message status.
     *
     * @return string
     */
    public function getDetailsUrl() : string;
}
