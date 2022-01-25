<?php

namespace AwesomeSystem\Command\Docker;

use AwesomeSystem\CliUtil;
use AwesomeSystem\DockerUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class RestartCommand extends Command
{
    protected static $defaultName = 'docker:restart';

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $containers = DockerUtil::getStoppedContainers();

        $process = new Process(CliUtil::getChooserCommand('Restart docker container'));

        $process->setInput(implode("\n", $containers));

        $process->run();

        if ($process->isSuccessful()) {
            $container = substr(trim($process->getOutput()), 0, 12);
            $process = new Process('docker restart '.$container);
            $process->run();
            if ($process->isSuccessful()) {
                $output->writeln('<info>Container restarted</info>');
                exit(0);
            } else {
                $output->writeln('<error>Failed to start container</error>');
                exit(1);
            }
        }
    }
}
