<?php

declare(strict_types=1);

namespace AwesomeSystem;

class CliUtil
{
    private static string $mode = 'osx';

    public static function getChooserCommand(string $title = ''): string
    {
        if (self::$mode == 'osx') {
            return 'choose -w 90 -u';
        }

        return "rofi -dmenu -msg \"{$title}\"";
    }

    public static function getTerminalForCommand(string $command):string{
        if(self::$mode == 'osx'){
            return "osascript -e '
            tell application \"iTerm2\"
                set newWindow to (create window with default profile)
                tell current session of newWindow
                    write text \"{$command} ; exit\"
                    activate
                end tell
            end tell'";
        }

        return "terminator -e \"{$command}\"";
        
    }
}