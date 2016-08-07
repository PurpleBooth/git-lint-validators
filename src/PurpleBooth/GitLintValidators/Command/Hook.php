<?php
declare(strict_types = 1);

namespace PurpleBooth\GitLintValidators\Command;

use PurpleBooth\GitLintValidators\MessageImplementation;
use PurpleBooth\GitLintValidators\Status\Status;
use PurpleBooth\GitLintValidators\ValidatorFactoryImplementation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * A command that allows you to try out the library
 *
 * @package PurpleBooth\GitGitHubLint\Command
 */
class Hook extends Command
{
    const COMMAND_NAME                 = 'git-lint-validator:hook';
    const ARGUMENT_COMMIT_MESSAGE_FILE = 'commit-message-file';
    const OPTION_COMMENT_CHAR          = 'comment-char';
    const OPTION_IGNORE                = 'ignore';

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription("Check the style of commit messages");

        $help  = '';
        $help .= "Check your commit messages to ensure they follow the guidelines\n";
        $help .= "in your add this to your .git/hooks/commit-msg file\n";
        $help .= "\n";
        $help .= "\n";
        $help .= "Here are some good articles on commit message style:\n";
        $help .= "\n";
        $help .= "* http://chris.beams.io/posts/git-commit/\n";
        $help .= "* https://git-scm.com/book/ch5-2.html#Commit-Guidelines\n";
        $help .= "* https://github.com/blog/926-shiny-new-commit-styles\n";

        $this->setHelp($help);
        $this->setDefinition(
            new InputDefinition(
                [
                    new InputArgument(
                        self::ARGUMENT_COMMIT_MESSAGE_FILE,
                        InputArgument::REQUIRED,
                        'Path to commit message file'
                    ),
                    new InputOption(
                        self::OPTION_IGNORE,
                        ['i'],
                        InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
                        'Ignore a commit message that matches this pattern and don\'t test it',
                        ['/^Merge branch/']
                    ),
                    new InputOption(
                        self::OPTION_COMMENT_CHAR,
                        ['c'],
                        InputOption::VALUE_OPTIONAL,
                        'Ignore lines that are prefixed with this character',
                        '#'
                    ),
                ]
            )
        );
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $styleHelper      = new SymfonyStyle($input, $output);
        $validatorFactory = new ValidatorFactoryImplementation();
        $validators       = $validatorFactory->getMessageValidator();

        $commitMessage    = file_get_contents($input->getArgument(self::ARGUMENT_COMMIT_MESSAGE_FILE));
        $commentCharacter = $input->getOption(self::OPTION_COMMENT_CHAR);
        $ignorePatterns   = $input->getOption(self::OPTION_IGNORE);

        foreach ($ignorePatterns as $ignorePattern) {
            if (preg_match($ignorePattern, $commitMessage)) {
                return 0;
            }
        }

        $safeCommitMessage = preg_replace("/" . preg_quote($commentCharacter) . ".*/", "", $commitMessage);
        $message           = new MessageImplementation($safeCommitMessage);

        $validators->validate($message);

        if (count($message->getStatuses()) < 1) {
            return 0;
        }

        $statusList = [];
        $isPositive = true;

        /** @var Status $status */
        foreach ($message->getStatuses() as $status) {
            $statusList[] = $status->getMessage() . " (" . $status->getDetailsUrl() . ")";

            $isPositive = $status->isPositive() && $isPositive;
        }


        if ($isPositive) {
            return 0;
        }

        $styleHelper->error("Incorrectly formatted commit message");
        $styleHelper->listing($statusList);

        $styleHelper->section("Your Commit Message");
        $styleHelper->block($commitMessage);
        $styleHelper->warning("A commit has not been created");

        return 1;
    }
}
