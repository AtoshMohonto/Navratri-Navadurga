<?php

namespace App\Core;

class Router
{
    protected array $routes = [];
    protected string $basePath = '';

    public function setBasePath(string $path): void
    {
        $this->basePath = rtrim($path, '/');
    }

    public function get(string $uri, $handler, array $middleware = []): void
    {
        $this->add('GET', $uri, $handler, $middleware);
    }

    public function post(string $uri, $handler, array $middleware = []): void
    {
        $this->add('POST', $uri, $handler, $middleware);
    }

    protected function add(string $method, string $uri, $handler, array $middleware): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => '/' . trim($uri, '/'),
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $uri = $request->uriPath($this->basePath);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = $this->compile($route['uri']);

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                foreach ($route['middleware'] as $middlewareClass) {
                    /** @var \App\Core\Middleware $middleware */
                    $middleware = new $middlewareClass();
                    if ($middleware->handle($request) === false) {
                        return;
                    }
                }

                $this->call($route['handler'], $request, $params);
                return;
            }
        }

        http_response_code(404);
        require dirname(__DIR__) . '/views/errors/404.php';
    }

    protected function compile(string $uri): string
    {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $uri);
        return '#^' . $pattern . '$#u';
    }

    protected function call($handler, Request $request, array $params): void
    {
        if ($handler instanceof \Closure) {
            call_user_func_array($handler, array_merge([$request], array_values($params)));
            return;
        }

        [$class, $method] = $handler;
        $controller = new $class();
        call_user_func_array([$controller, $method], array_merge([$request], array_values($params)));
    }

    public function basePath(): string
    {
        return $this->basePath;
    }
}
