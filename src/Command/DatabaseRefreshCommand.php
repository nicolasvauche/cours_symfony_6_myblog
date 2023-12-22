<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'app:database:refresh',
    description: 'Refreshes the database by dropping it, creating it, running migrations and loading fixtures.',
)]
class DatabaseRefreshCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Drop database
        $io->text('Dropping database...');
        $this->runCommand(['php', 'bin/console', 'doctrine:database:drop', '--force'], $output);

        // Create database
        $io->text('Creating database...');
        $this->runCommand(['php', 'bin/console', 'doctrine:database:create'], $output);

        // Run migrations
        $io->text('Running migrations...');
        $this->runCommand(['php', 'bin/console', 'doctrine:migrations:migrate', '-n'], $output);

        // Load fixtures
        $io->text('Loading fixtures...');
        $this->runCommand(['php', 'bin/console', 'doctrine:fixtures:load', '-n'], $output);

        // Clear cache
        $io->text('Clearing cache...');
        $this->runCommand(['php', 'bin/console', 'cache:clear'], $output);

        $io->success('Database has been refreshed successfully.');

        return Command::SUCCESS;
    }

    private function runCommand(array $command, OutputInterface $output): void
    {
        $process = new Process($command);
        $process->run();

        if(!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output->writeln($process->getOutput());
    }
}
