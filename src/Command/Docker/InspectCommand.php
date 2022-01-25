<?php

namespace AwesomeSystem\Command\Docker;

use AwesomeSystem\CliUtil;
use AwesomeSystem\DockerUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class InspectCommand extends Command
{
    protected static $defaultName = 'docker:inspect';

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $containers = DockerUtil::getStoppedContainers();

        $process = new Process(CliUtil::getChooserCommand('Inspect docker container'));

        $process->setInput(implode("\n", $containers));

        $process->run();

        if ($process->isSuccessful()) {
            $container = substr(trim($process->getOutput()), 0, 12);
            exec(CliUtil::getTerminalForCommand("docker inspect $container | less"));
        }
    }
}
