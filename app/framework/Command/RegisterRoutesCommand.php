<?php

namespace Framework\Command;


class RegisterRoutesCommand implements ICommand
{
    public function execute(array $params): array
    {
        $params['routeCollection'] = require $params['dir'] . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routing.php';
        $params['containerBuilder']->set('route_collection', $params['routeCollection']);

        return $params;
    }

}