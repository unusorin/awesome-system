<?php

namespace AwesomeSystem\Command\Web;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class BookmarksCommand
 * @package AwesomeSystem\Command\Web
 */
class BookmarksCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('web:bookmarks')
            ->setDescription('Open bookmarks');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bookmarks = json_decode(file_get_contents(getenv('HOME') . '/.config/google-chrome/Default/Bookmarks'));

        $bookmarks = $bookmarks->roots->bookmark_bar->children;

        $this->chooseItem($bookmarks);
    }

    private function chooseItem(array $items)
    {
        $results = [];
        foreach ($items as $item) {
            if (isset($item->url) && strpos(@$item->url, 'chrome://') !== false) {
                continue;
            }
            if (trim($item->name) == '') {
                continue;
            }
            $results[$item->name] = ['id' => $item->id, 'url' => @$item->url, 'children' => @$item->children];
        }

        $dmenuProcess = new Process('rofi -dmenu -mesg "Open a web bookmark"');

        $dmenuProcess->setInput(implode(PHP_EOL, array_keys($results)));

        $dmenuProcess->start();

        while ($dmenuProcess->isRunning()) {
            sleep(1);
        }

        if ($dmenuProcess->isSuccessful()) {
            $selection = $results[trim($dmenuProcess->getOutput())];
            if (!$selection) {
                return;
            }
            if ($selection['url']) {
                exec('google-chrome ' . $selection['url']);
            } else {
                $this->chooseItem($selection['children']);
            }
        }
    }
}