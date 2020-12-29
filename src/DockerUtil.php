<?php

namespace AwesomeSystem;

use Symfony\Component\Process\Process;

class DockerUtil
{
    static public function getRunningContainers()
    {
        $process = new Process('docker ps --format="{{.ID}} - {{.Names}} - {{.Image}} ({{.Status}})"');
        $process->run();

        if ($process->isSuccessful()) {
            return explode("\n", trim($process->getOutput()));
        } else {
            return [];
        }
    }

    static public function getStoppedContainers()
    {
        $process = new Process('docker ps -a --format="{{.ID}} - {{.Names}} - {{.Image}} ({{.Status}})"');
        $process->run();

        if ($process->isSuccessful()) {
            return explode("\n", trim($process->getOutput()));
        } else {
            return [];
        }
    }
}