<?php

declare(strict_types=1);

namespace PurpleBooth\GitLintValidators;

use PurpleBooth\GitLintValidators\Status\Status;

/**
 * A commit message.
 */
class MessageImplementation implements Message
{
    /**
     * @var array
     */
    private $commitMessage;

    /**
     * @var Status[]
     */
    private $statuses = [];

    /**
     * Message constructor.
     *
     * @param string $commitMessage
     */
    public function __construct(string $commitMessage)
    {
        $this->commitMessage = explode("\n", $commitMessage);
    }

    /**
     * Is the title capitalised.
     *
     * @return bool
     */
    public function isTitleCapitalised() : bool
    {
        if ($this->getTitleLength() == 0) {
            return false;
        }

        return strtoupper($this->commitMessage[0]){0}
        === $this->commitMessage[0][0];
    }

    /**
     * Get the title length.
     *
     * @return int
     */
    public function getTitleLength() : int
    {
        return strlen($this->commitMessage[0]);
    }

    /**
     * Title ends with a full stop.
     *
     * @return bool
     */
    public function hasTitleAFullStop() : bool
    {
        if ($this->getTitleLength() == 0) {
            return false;
        }

        $lastCharacter = trim($this->commitMessage[0]){$this->getTitleLength() - 1};

        return $lastCharacter == '.';
    }

    /**
     * Has a gap after the title.
     *
     * @return bool
     */
    public function hasBlankLineAfterTitle() : bool
    {
        if (count($this->commitMessage) < 2) {
            return false;
        }

        return $this->commitMessage[1] == '';
    }

    /**
     * Has this message got a body.
     *
     * @return bool
     */
    public function hasABody(): bool
    {
        // Has a body
        if ($this->getBodyWrapLength() > 0) {
            // First line isn't long
            return strlen($this->commitMessage[2]) > 0;
        }

        return false;
    }

    /**
     * The length at which the message wraps.
     *
     * @return int
     */
    public function getBodyWrapLength() : int
    {
        if (count($this->commitMessage) < 3) {
            return 0;
        }

        $body = array_slice($this->commitMessage, 2);
        $longestLineLength = 0;

        foreach ($body as $line) {
            if (strlen($line) > $longestLineLength) {
                $longestLineLength = strlen($line);
            }
        }

        return $longestLineLength;
    }

    /**
     * Associate a status with this message.
     *
     * @param Status $status
     */
    public function addStatus(Status $status)
    {
        $this->statuses[] = $status;
    }

    /**
     * Get the status associated with this message.
     *
     * @return Status[]
     */
    public function getStatuses() : array
    {
        return $this->statuses;
    }
}
