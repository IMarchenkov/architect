<?php

namespace Framework\Command;

use Framework\Registry;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ProcessCommand implements ICommand
{
    public function execute(array $params): array
    {
        $matcher = new UrlMatcher($params['routeCollection'], new RequestContext());
        $matcher->getContext()->fromRequest($params['request']);

        try {
            $params['request']->attributes->add($matcher->match($params['request']->getPathInfo()));
            $params['request']->setSession(new Session());

            $controller = (new ControllerResolver())->getController($params['request']);
            $arguments = (new ArgumentResolver())->getArguments($params['request'], $controller);

            $params['response'] = call_user_func_array($controller, $arguments);
            return $params;
        } catch (ResourceNotFoundException $e) {
            $params['response'] = new Response('Page not found. 404', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            $error = 'Server error occurred. 500';
            if (Registry::getDataConfig('environment') === 'dev') {
                $error .= '<pre>' . $e->getTraceAsString() . '</pre>';
            }

            $params['response'] = new Response($error, Response::HTTP_INTERNAL_SERVER_ERROR);

            return $params;
        }
    }

}