<?php

declare(strict_types=1);

/*
 * Copyright (C) 2016 Billie Thompson
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace PurpleBooth\GitLintValidators\Composer;

use Composer\IO\IOInterface;
use Composer\Script\Event;

class Scripts
{
    const BACKUP_EXTENSION = '.bak';

    const GIT_PATH = '.git';

    const HOOKS_PATH = 'hooks';

    const HOOK_FILENAME = 'commit-msg';

    const TEMPLATE_FILENAME = '.gitmessage';

    /**
     * Default Permissions (Copied from example hooks).
     *
     * User: Read, Write, Execute
     * Group: Read, Execute
     * Other: Execute
     */
    const EXECUTABLE_PERMISSIONS = 0751;

    const HOOK_CONTENTS = <<<'CONTENT'
#!/bin/sh

vendor/bin/git-lint-validators git-lint-validator:hook $1
CONTENT;

    const TEMPLATE_CONTENTS = <<<'CONTENT'
Subject line

# - Capitalise the subject line and do not end it with a period
# - Use the imperative mood in the subject line
# - Summarise changes in around 50 (soft limit, hard limit at 69)
#   characters or less in the subject line
# - Separate subject line from body with a blank line
Subject body
# - Use the subject body to explain what and why vs. how
# - Wrap the subject body at 72 characters

CONTENT;

    /**
     * Installs and activates the Git commit message
     * hook when confirmed by the user. An existing hook
     * is backed with the .bak extension.
     *
     * @param Event $event The script event
     *
     * @return bool
     */
    public static function installGitMessageHook(Event $event)
    {
        $hookContent = self::HOOK_CONTENTS;
        $inputOutput = $event->getIO();
        $question = 'Do you want to install and activate the Git ';
        $question .= 'commit message hook? ';

        if ($inputOutput->askConfirmation($question, false)) {
            $errorMessage = "Couldn't locate the .git directory. ";
            $errorMessage .= 'Aborting the Git hook installation.';

            $gitDirectory = self::getGuardedGitDirectory($errorMessage, $inputOutput);

            if (false === $gitDirectory) {
                return false;
            }

            $hookFile = implode(DIRECTORY_SEPARATOR, [$gitDirectory, self::HOOKS_PATH, self::HOOK_FILENAME]);
            $existingHookFile = false;

            if (file_exists($hookFile)) {
                $existingHookFile = copy(
                    $hookFile,
                    $hookFile.self::BACKUP_EXTENSION
                );
            }

            file_put_contents($hookFile, $hookContent);
            chmod($hookFile, self::EXECUTABLE_PERMISSIONS);

            $inputOutput->write('Installed and activated the Git commit message hook.');

            if ($existingHookFile) {
                $inputOutput->write('Backed previous Git commit message hook.');
            }

            if ($inputOutput->isVerbose()) {
                $inputOutput->write('Wrote');
                $inputOutput->write("<comment>$hookContent</comment>");
                $inputOutput->write("into <info>$hookFile</info> and made it executable.");
            }

            return true;
        }

        $inputOutput->write('Aborted installation and activation of the Git commit message hook.');

        return false;
    }

    /**
     * Installs and configures the Git commit message
     * template when confirmed by the user.
     *
     * @param Event $event The script event
     *
     * @return bool
     */
    public static function installGitCommitMessageTemplate(Event $event)
    {
        $templateContent = self::TEMPLATE_CONTENTS;
        $inputOutput = $event->getIO();
        $question = 'Do you want to install and configure the Git ';
        $question .= 'commit message template? ';

        if ($inputOutput->askConfirmation($question, false)) {
            $errorMessage = "Couldn't locate the .git directory. ";
            $errorMessage .= 'Aborting the Git commit message template installation.';

            $gitDirectory = self::getGuardedGitDirectory($errorMessage, $inputOutput);

            if (false === $gitDirectory) {
                return false;
            }

            $templateFile = implode(DIRECTORY_SEPARATOR, [$gitDirectory, self::TEMPLATE_FILENAME]);

            file_put_contents($templateFile, $templateContent);
            $gitConfigureCommand = "git config --add commit.template $templateFile";
            exec($gitConfigureCommand);

            $inputOutput->write('Installed and configured the Git commit message template.');

            if ($inputOutput->isVerbose()) {
                $inputOutput->write('Wrote');
                $inputOutput->write("<comment>$templateContent</comment>");
                $inputOutput->write("into <info>$templateFile</info> and configured the Git commit message template ");
                $inputOutput->write("via <comment>$gitConfigureCommand</comment>.");
            }

            return true;
        }

        $inputOutput->write('Aborted installation and configuration of the Git commit message template.');

        return false;
    }

    /**
     * Returns the .git directory if present. Errors the given
     * message if not.
     *
     * @param string      $message     The message to error
     * @param IOInterface $inputOutput The Input/Output helper interface
     *
     * @return false|string
     */
    private static function getGuardedGitDirectory($message, IOInterface $inputOutput)
    {
        $gitDirectory = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__, 4), self::GIT_PATH]);

        if (!is_dir($gitDirectory)) {
            $inputOutput->error($message);

            return false;
        }

        return $gitDirectory;
    }
}
