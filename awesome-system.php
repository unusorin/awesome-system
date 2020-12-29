<?php

namespace App;

use AwesomeSystem\Command\MenuCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

require_once 'vendor/autoload.php';

$finder = new Finder();

/** @var \SplFileInfo $file */
foreach ($finder->in(__DIR__.'/src/')->name('*.php')->files() as $file) {
    require_once $file->getPathname();
}

$app = new Application('Awesome System', '0.2.0');

$app->add(new MenuCommand($app));


$commands = array_filter(
    get_declared_classes(),
    function ($className) {
        return strpos($className, 'AwesomeSystem\Command\\') !== false &&
            $className != MenuCommand::class;
    }
);

array_map(function ($commandClassName) use ($app) {
    $app->add(new $commandClassName);
}, $commands);

$app->setDefaultCommand('start');

$app->run();
