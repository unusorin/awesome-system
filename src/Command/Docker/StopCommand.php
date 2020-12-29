<?php

namespace AwesomeSystem\Command\Docker;

use AwesomeSystem\DockerUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class StopCommand extends Command
{
    protected static $defaultName = 'docker:stop';

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $containers = DockerUtil::getRunningContainers();

        $process = new Process('rofi -dmenu -msg "Stop a docker container"');

        $process->setInput(implode("\n", $containers));

        $process->run();

        if ($process->isSuccessful()) {
            $container = substr(trim($process->getOutput()), 0, 12);
            $process   = new Process('docker stop ' . $container);
            $process->run();
            if ($process->isSuccessful()) {
                $output->writeln('<info>Container stopped</info>');
                exit(0);
            } else {
                $output->writeln('<error>Failed to stop container</error>');
                exit(1);
            }
        }
    }
}
