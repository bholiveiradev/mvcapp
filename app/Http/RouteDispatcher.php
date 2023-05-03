<?php

declare(strict_types=1);

namespace App\Http;

use App\Middlewares\Contracts\MiddlewareInterface;
use Exception;

class RouteDispatcher
{
    private array $routeCollection;

    public function __construct(array $routes)
    {
        $this->routeCollection = $routes;
    }

    public function dispatch(Request $request, Response $response): mixed
    {
        foreach ($this->routeCollection as $route) {
            if ($request->getMethod() === $route['method']) {
                $pathRegex = $this->pathToRegex($route['uri']);
    
                if (preg_match($pathRegex, $request->getUri(), $matches)) {
                    array_shift($matches);
                    $request->setParams($matches);
    
                    $middlewares = $route['middlewares'];
    
                    $next = function () use ($request, $response, $route, $matches) {
                        $handler = $route['handler'];

                        if ($handler instanceof \Closure) {
                            return $handler($request, $response);
                        }

                        if (is_array($handler)) {
                            list ($controller, $method) = $handler;
                            return (new $controller)->$method($request, $response);
                        }

                        if (class_exists($handler)) {
                            return call_user_func(new $handler($matches));
                        }

                        throw new Exception('Not Implemented', 501);
                    };
    
                    foreach (array_reverse($middlewares) as $middleware) {
                        $middlewareObject = new $middleware;
    
                        if (!$middlewareObject instanceof MiddlewareInterface) {
                            throw new Exception("$middleware must implement MiddlewareInterface");
                        }
    
                        $next = function () use ($request, $response, $middlewareObject, $next) {
                            return $middlewareObject->handle($request, $response, $next);
                        };
                    }
    
                    return $next();
                }
            }
        }
    
        throw new Exception('Route not found', 404);
    }

    private function pathToRegex(string $path): string
    {
        $regex = preg_replace('#\{([\w]+)\}#', '(?P<$1>[^/]+)', $path);
        return '#^' . $regex . '$#';
    }
}