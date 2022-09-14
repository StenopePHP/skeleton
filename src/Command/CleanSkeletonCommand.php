<?php

declare(strict_types=1);

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

#[AsCommand('skeleton:clean', description: 'Clean the skeleton app')]
class CleanSkeletonCommand extends Command
{
    public function __construct(private readonly ?LoggerInterface $logger = null)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Cleaning the skeleton app');

        if (false === $io->confirm('Would you like to clean the skeleton app (or keep the demo files)?', false)) {
            $io->success('Keeping everything as is.');

            return Command::SUCCESS;
        }

        $gitPath = 'git';
        $executable = explode(' ', $gitPath);

        // Check once if the git command is available
        $process = new Process([...$executable, '--version']);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->logger?->error('Git was not found at path "{gitPath}". Check the binary path is correct or part of your PATH.', [
                'gitPath' => $gitPath,
                'output' => $process->getOutput(),
                'err_output' => $process->getErrorOutput(),
            ]);

            $io->error('Git is required.');

            return Command::FAILURE;
        }

        $process = new Process([...$executable, 'apply', '.patches/clean_content.patch']);
        $process->run();

        $io->comment('Removing the demo content files…');

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $io->comment('[DONE] Removed the demo content files');

        if (false === $io->confirm('Would you like to remove the Glide integration?', false)) {
            $this->removeSelf($executable);

            return Command::SUCCESS;
        }

        $process = new Process([...$executable, 'apply', '.patches/rm_glide.patch']);
        $process->run();

        $io->comment('Removing the Glide integration…');

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $process = new Process(['composer', 'remove', 'league/glide-symfony']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $io->comment('[DONE] Removed the Glide integration');

        $this->removeSelf($executable);

        return Command::SUCCESS;
    }

    private function removeSelf(array $executable): void
    {
        $process = new Process([...$executable, 'rm', '-rf', './.patches', './src/Command/CleanSkeletonCommand.php']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
