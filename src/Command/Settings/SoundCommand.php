<?php

namespace AwesomeSystem\Command\Settings;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SoundCommand extends Command
{
    protected static $defaultName = 'settings:sound';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        exec("terminator -e \"alsamixer\"");
    }
}
