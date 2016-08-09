<?php
declare(strict_types = 1);
namespace PurpleBooth\GitLintValidators\Composer;

use Composer\Script\Event;

class Scripts
{

    /**
     * Installs and activates the Git commit message
     * hook when confirmed by the user. An existing hook
     * is backed with the .bak extension.
     *
     *
     * @param  Event $event The script event.
     * @return boolean
     */
    public static function installGitMessageHook(Event $event)
    {
        $gitHookContent = <<<CONTENT
#!/bin/sh

vendor/bin/git-lint-validators git-lint-validator:hook $1
CONTENT;

        $io = $event->getIO();
        $question = "Do you want to install and activate the Git "
            . "commit message hook? ";

        if ($io->askConfirmation($question, false)) {
            $gitDirectory = dirname(__DIR__, 4) . DIRECTORY_SEPARATOR . '.git';
            if (!is_dir($gitDirectory)) {
                $errorMessage = "Couldn't locate the .git directory. "
                    . "Aborting the Git hook installation.";
                $io->error($errorMessage);

                return false;
            }

            $gitCommitMessageHookFile = $gitDirectory
                . DIRECTORY_SEPARATOR . 'hooks'
                . DIRECTORY_SEPARATOR . 'commit-msg';

            $backedExistingGitCommitMessageHookFile = false;
            if (file_exists($gitCommitMessageHookFile)) {
                $backedExistingGitCommitMessageHookFile = copy(
                    $gitCommitMessageHookFile,
                    $gitCommitMessageHookFile . '.bak'
                );
            }

            file_put_contents($gitCommitMessageHookFile, $gitHookContent);
            chmod($gitCommitMessageHookFile, 0751);

            $io->write("Installed and activated the Git commit message hook.");

            if ($backedExistingGitCommitMessageHookFile) {
                $io->write("Backed previous Git commit message hook.");
            }

            if ($io->isVerbose()) {
                $io->write("Wrote");
                $io->write("<comment>$gitHookContent</comment>");
                $io->write("into <info>$gitCommitMessageHookFile</info> and made it executable.");
            }

            return true;
        }

        $io->write("Aborted installation and activation of the Git commit message hook.");

        return false;
    }
}
