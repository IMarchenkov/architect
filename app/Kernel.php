<?php

declare(strict_types = 1);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;

use Framework\Command\RegisterConfigsCommand;

class Kernel
{
    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    /**
     * @var array
     */
    protected $params;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->params = [
            'dir' => __DIR__,
            'containerBuilder' => $containerBuilder
        ];
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $this->params['request'] = $request;
        $this->params = (new RegisterConfigsCommand())->execute($this->params);
        $this->params = (new \Framework\Command\RegisterRoutesCommand())->execute($this->params);
        $this->params = (new \Framework\Command\ProcessCommand())->execute($this->params);


        return $this->params['response'];
    }
}
