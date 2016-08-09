<?php
declare(strict_types = 1);
namespace PurpleBooth\GitLintValidators\Composer;

use Composer\Script\Event;

class Scripts
{
    const BACKUP_EXTENSION = '.bak';
    const GIT_PATH         = '.git';
    const HOOKS_PATH       = 'hooks';
    const HOOK_FILENAME    = 'commit-msg';

    /**
     * Default Permissions (Copied from example hooks)
     *
     * User: Read, Write, Execute
     * Group: Read, Execute
     * Other: Execute
     */
    const EXECUTABLE_PERMISSIONS = 0751;
    const HOOK_CONTENTS          = <<<CONTENT
#!/bin/sh

vendor/bin/git-lint-validators git-lint-validator:hook $1
CONTENT;

    /**
     * Installs and activates the Git commit message
     * hook when confirmed by the user. An existing hook
     * is backed with the .bak extension.
     *
     *
     * @param  Event $event The script event.
     *
     * @return boolean
     */
    public static function installGitMessageHook(Event $event)
    {
        $hookContent = self::HOOK_CONTENTS;
        $inputOutput = $event->getIO();
        $question    = "Do you want to install and activate the Git ";
        $question   .= "commit message hook? ";

        if ($inputOutput->askConfirmation($question, false)) {
            $gitDirectory = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__, 4), self::GIT_PATH]);

            if (!is_dir($gitDirectory)) {
                $errorMessage  = "Couldn't locate the .git directory. ";
                $errorMessage .= "Aborting the Git hook installation.";

                $inputOutput->error($errorMessage);

                return false;
            }

            $hookFile         = implode(DIRECTORY_SEPARATOR, [$gitDirectory, self::HOOKS_PATH, self::HOOK_FILENAME]);
            $existingHookFile = false;

            if (file_exists($hookFile)) {
                $existingHookFile = copy(
                    $hookFile,
                    $hookFile . self::BACKUP_EXTENSION
                );
            }

            file_put_contents($hookFile, $hookContent);
            chmod($hookFile, self::EXECUTABLE_PERMISSIONS);

            $inputOutput->write("Installed and activated the Git commit message hook.");

            if ($existingHookFile) {
                $inputOutput->write("Backed previous Git commit message hook.");
            }

            if ($inputOutput->isVerbose()) {
                $inputOutput->write("Wrote");
                $inputOutput->write("<comment>$hookContent</comment>");
                $inputOutput->write("into <info>$hookFile</info> and made it executable.");
            }

            return true;
        }

        $inputOutput->write("Aborted installation and activation of the Git commit message hook.");

        return false;
    }
}
