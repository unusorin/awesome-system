<?php

namespace AwesomeSystem\Command\Web;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class OpenCommand
 *
 * @package AwesomeSystem\Command\Web
 */
class QuickCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('web:quick')
            ->setDescription('Open quick links');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $webApps = json_decode(file_get_contents(__DIR__.'/../../../quicklinks.json'), true);



        $dmenuProcess = new Process('rofi -dmenu -mesg "Open a web quicklink"');

        $dmenuProcess->setInput(implode(PHP_EOL, array_keys($webApps)));

        $dmenuProcess->start();

        while ($dmenuProcess->isRunning()) {
            sleep(1);
        }

        if ($dmenuProcess->isSuccessful()) {
            $webApp = trim($dmenuProcess->getOutput());
            exec('google-chrome '.$webApps[$webApp]);
        }
    }
}
