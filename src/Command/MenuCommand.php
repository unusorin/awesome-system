<?php

namespace AwesomeSystem\Command;

use AwesomeSystem\CliUtil;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class MenuCommand
 *
 * @package AwesomeSystem\Command
 */
class MenuCommand extends Command
{
    private $consoleApplication;

    /**
     * MenuCommand constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->consoleApplication = $application;
        parent::__construct(null);
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('start')
            ->setDescription('Start awesome system dmenu');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = array_filter(array_keys($this->consoleApplication->all()), function ($command) {
            return strpos($command, ':') !== false;
        });
        sort($commands);
        $process = new Process(CliUtil::getChooserCommand());

        $process->setInput(implode("\n", $commands));

        $process->start();

        while ($process->isRunning()) {
            sleep(1);
        }

        if ($process->isSuccessful()) {
            $command = $this->consoleApplication->find(trim($process->getOutput()));

            return $command->execute($input, $output);
        }
    }
}
