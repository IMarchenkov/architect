<?php

namespace Framework\Command;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class RegisterConfigsCommand implements ICommand
{
    public function execute(array $params): array
    {
        try {
            $fileLocator = new FileLocator($params['dir'] . DIRECTORY_SEPARATOR . 'config');
            $loader = new PhpFileLoader($params['containerBuilder'], $fileLocator);
            $loader->load('parameters.php');
        } catch (\Throwable $e) {
            die('Cannot read the config file. File: ' . __FILE__ . '. Line: ' . __LINE__);
        }

        return $params;
    }
}