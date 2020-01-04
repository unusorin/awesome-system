<?php

namespace AwesomeSystem\Command\Docker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LazyCommand extends Command
{
    protected static $defaultName = 'docker:lazy';

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        pcntl_exec('/usr/bin/env', ['terminator', '-e', 'lazydocker']);
    }
}
