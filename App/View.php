<?php

declare(strict_types=1);

namespace App;

class View
{
    protected $layout;
    public function __construct(string $layout = "app")
    {
        $this->layout = $layout;
    }

    public function renderContent(string $view, $params = []): void
    {
        echo str_replace('{{content}}', $this->getView($view, $params), $this->getView($this->layout));
        exit;
    }

    public function render(string $content, string $view): void
    {
        echo str_replace($content, $this->getView($view), $this->getView($this->layout));
        exit;
    }

    public function fetchContent(string $view, $params = []): bool | string
    {
        return str_replace('{{content}}', $this->getView($view, $params), $this->getView($this->layout));
    }

    public function fetchResponse(string $view, $params = []): bool | string
    {
        return $this->getView($view, $params);
    }

    protected function getView(string $view, $params = []): bool | string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once dirname(__DIR__) . "/resources/views/$view.php";
        return ob_get_clean();
    }
}
