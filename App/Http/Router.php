<?php
/**
 * Router class
 */
declare(strict_types=1);

namespace App\Http;

use App\View;

class Router
{

    /**
     * List of routes
     * @var array $routes
     */
    protected array $routes = [];
    /**
     * Request object
     * @var Request $request
     */
    public Request $request;
    /**
     * Response object
     * @var Response $response
     */
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;


    }

    /**
     * Register a new GET route
     * @param string $path
     * @param string|array $callback
     */
    public function get(string $path, string|array $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Register a new POST route
     * @param string $path
     * @param string|array $callback
     */
    public function post(string $path, string|array $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Return the list of routes for a given method
     * @param string $method
     * @return array
     */
    public function getRouteMap(string $method): array
    {
        return $this->routes[$method] ?? [];
    }

    /**
     * Get the callback for the current route
     * @return mixed
     */
    private function getCallback(): mixed
    {
        $method = $this->request->getMethod();
        $url = $this->request->getPath();

        $url = trim($url, '/');

        $routes = $this->getRouteMap($method);

        $routeParams = false;

        foreach ($routes as $route => $callback) {

            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

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
     * Resolve the current route
     * @return mixed
     */
    public function resolve()
    {
        $view = new View();
        $method = $this->request->getMethod();
        $url = $this->request->getPath();
        $callback = $this->routes[$method][$url] ?? false;

        if (!$callback) {
            $callback = $this->getCallback();
            if ($callback === false) {
                $view->renderContent('_404');
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