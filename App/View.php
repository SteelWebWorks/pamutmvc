<?php
/**
 * View class
 * Provides the view functionality
 */

declare(strict_types=1);

namespace App;

use JetBrains\PhpStorm\NoReturn;

class View
{
    protected string $layout;
    public function __construct(string $layout = "app")
    {
        $this->layout = $layout;
    }

    /**
     * Render the content
     * @param string $view
     * @param array $params
     */
    #[NoReturn] public function renderContent(string $view, array $params = []): void
    {
        echo str_replace('{{content}}', $this->getView($view, $params), $this->getView($this->layout));
        exit;
    }

    /**
     * Render the view
     * @param string $content
     * @param string $view
     * @param array $params
     */
    #[NoReturn] public function render(string $content, string $view, array $params = []): void
    {
        echo str_replace($content, $this->getView($view, $params), $this->getView($this->layout));
        exit;
    }

    /**
     * Render the response
     * @param string $view
     * @param array $params
     */
    #[NoReturn] public function renderResponse(string $view, array $params = []): void
    {
        echo $this->getView($view, $params);
        exit;
    }

    /**
     * Fetch the content
     * @param string $view
     * @param array $params
     * @return bool|string
     */
    public function fetchContent(string $view, array $params = []): bool | string
    {
        return str_replace('{{content}}', $this->getView($view, $params), $this->getView($this->layout));
    }

    /**
     * Fetch the view
     * @param string $view
     * @param array $params
     * @return bool|string
     */
    public function fetchResponse(string $view, array $params = []): bool | string
    {
        return $this->getView($view, $params);
    }

    /**
     * Get the view
     * @param string $view
     * @param array $params
     * @return bool|string
     */
    protected function getView(string $view, array $params = []): bool | string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once dirname(__DIR__) . "/resources/views/$view.php";
        return ob_get_clean();
    }
}
