<?php

namespace AwesomeSystem\Command\Settings;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class DisplayCommand extends Command
{
    protected static $defaultName = 'settings:display';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();

        $finder->in($basePath = getenv('HOME').'/.screenlayout')->name('*.sh');

        $profiles = [];

        /** @var \SplFileInfo $file */
        foreach ($finder->files() as $file) {
            $profiles[] = $file->getFilename();
        }

        $dmenuProcess = new Process('rofi -dmenu -mesg "Select arandr profile"');

        $dmenuProcess->setInput(implode(PHP_EOL, $profiles));

        $dmenuProcess->start();

        while ($dmenuProcess->isRunning()) {
            sleep(1);
        }

        if ($dmenuProcess->isSuccessful()) {
            $profile = trim($dmenuProcess->getOutput());
            exec("bash $basePath/$profile");
            exec("feh --bg-fill ~/.config/i3/wallpaper.png");
        }
    }
}
