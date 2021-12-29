<?php

namespace AwesomeSystem\Command\PStorm;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class ListProjectCommand
 *
 * @package AwesomeSystem\Command\PStorm
 */
class OpenCommand extends Command
{
    private $projects = [];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('pstorm:open')
            ->setDescription('Open PhpStorm Project')
            ->addOption(
                'baseDir',
                null,
                InputOption::VALUE_OPTIONAL,
                'Which is the base dir in which to search for?'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->hasOption('baseDir')) {
            $baseDir = $input->getOption('baseDir');
        } else {
            $baseDir = '/workspace';
        }

        if (!is_dir($baseDir)) {
            throw new \RuntimeException('Base directory does not exists');
        }

        $this->getProjects($baseDir);

        $projectsRaw = '';

        foreach ($this->projects as $project) {
            $projectsRaw .= str_replace(getenv("HOME"), '~', $project).PHP_EOL;
        }


        $dmenuProcess = new Process('rofi -dmenu -mesg "Open project with PhpStorm"');

        $dmenuProcess->setInput($projectsRaw);

        $dmenuProcess->start();

        while ($dmenuProcess->isRunning()) {
            sleep(1);
        }

        if ($dmenuProcess->isSuccessful()) {
            $pstormCommand = 'pstorm '.trim($dmenuProcess->getOutput());
            exec($pstormCommand);
        }
    }

    /**
     * @param $basePath
     */
    private function getProjects($basePath)
    {
        foreach (scandir($basePath) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            //own ecosystem
            if (is_file("{$basePath}/{$file}/awesome-project.yaml")) {
                $this->projects[] = "$basePath/$file";
                $this->getProjects("{$basePath}/{$file}");
                continue;
            }
            if (is_dir("{$basePath}/{$file}/.git")) {
                $this->projects[] = "$basePath/$file";
                continue;
            }
            if (is_dir("{$basePath}/{$file}")) {
                $this->getProjects("{$basePath}/{$file}");
            }
        }
    }
}
