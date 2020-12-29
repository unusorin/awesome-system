<?php

namespace AwesomeSystem\Command\Docker;

use AwesomeSystem\DockerUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class LogsCommand extends Command
{
    protected static $defaultName = 'docker:logs';

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $containers = DockerUtil::getStoppedContainers();

        $process = new Process('rofi -dmenu -msg "Tail logs for docker container"');

        $process->setInput(implode("\n", $containers));

        $process->run();

        if ($process->isSuccessful()) {
            $container = substr(trim($process->getOutput()), 0, 12);
            exec("terminator -e \"docker logs $container --follow\"");
        }
    }
}
