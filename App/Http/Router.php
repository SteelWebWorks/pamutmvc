<?php

namespace App\Http;

use App\View;

class Router
{

    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;


    }

    public function get(string $path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function getRouteMap($method): array
    {
        return $this->routes[$method] ?? [];
    }

    private function getCallback(): mixed
    {
        $method = $this->request->getMethod();
        $url = $this->request->getPath();
        // Trim slashes
        $url = trim($url, '/');
        // Get all routes for current request method
        $routes = $this->getRouteMap($method);

        $routeParams = false;
        /* echo "<pre>";
        var_dump($routes);
        echo "</pre>"; */

        // Start iterating registed routes
        foreach ($routes as $route => $callback) {
            // Trim slashes
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }
            /* echo "<pre>";
            var_dump($route);
            echo "</pre>"; */
            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }
            /* echo "<pre>";
            var_dump($routeNames);
            echo "</pre>"; */
            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function resolve(): mixed
    {
        $view = new View();
        $method = $this->request->getMethod();
        $url = $this->request->getPath();
        $callback = $this->routes[$method][$url] ?? false;

        if (!$callback) {
            $callback = $this->getCallback();
            if ($callback === false) {
                $view->renderContent('_404');
                exit;
            }
        }

        if (is_string($callback)) {
            $position = strpos($callback, "@");
            if ($position > 0) {
                $callback = explode("@", $callback);
                $controller = '\\App\\Controllers\\' . $callback[0];
                $callback[0] = new $controller($this->request, $this->response);
            } else {
                $view->renderContent($callback);
            }
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]($this->request, $this->response);
        }
        return call_user_func($callback);

    }
}
