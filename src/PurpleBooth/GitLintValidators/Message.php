<?php
declare(strict_types = 1);
namespace PurpleBooth\GitLintValidators;

use PurpleBooth\GitLintValidators\Status\Status;

/**
 * A commit message
 *
 * @package PurpleBooth\GitLintValidators
 */
interface Message
{
    /**
     * Is the title capitalised
     *
     * @return bool
     */
    public function isTitleCapitalised() : bool;

    /**
     * Get the title length
     *
     * @return int
     */
    public function getTitleLength() : int;

    /**
     * Title ends with a full stop
     *
     * @return bool
     */
    public function hasTitleAFullStop() : bool;

    /**
     * Has a gap after the title
     *
     * @return bool
     */
    public function hasBlankLineAfterTitle() : bool;

    /**
     * Has this message got a body
     *
     * @return bool
     */
    public function hasABody() : bool;

    /**
     * The length at which the message wraps
     *
     * @return int
     */
    public function getBodyWrapLength() : int;

    /**
     * Associate a status with this message
     *
     * @param Status $status
     *
     * @return void
     */
    public function addStatus(Status $status);

    /**
     * Get the number of statuses
     *
     * @return int
     */
    public function getStatusCount() : int;
}
