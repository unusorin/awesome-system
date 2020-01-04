<?php

namespace AwesomeSystem;

use Symfony\Component\Process\Process;

/**
 * Class Notification
 *
 * @package AwesomeSystem
 */
class Notification
{
    /**
     * @param      $message
     * @param null $icon
     */
    static public function notify($message, $icon = null)
    {
        if ($icon) {
            $command = "notify-send -i $icon \"$message\"";
        } else {
            $command = "notify-send \"$message\"";
        }

        $process = new Process($command);
        $process->run();
    }
}
