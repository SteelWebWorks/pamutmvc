<?php
/**
 * Response class
 * Provides the response data
 */

declare(strict_types=1);

namespace App\Http;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    /**
     * Set the status code for the response
     */
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * Redirect to a different page
     */
    public function redirect($url): void
    {
        header("Location: $url");
    }

    /**
     * Send a JSON response
     */
    #[NoReturn] public function json(array $data): void
    {
        echo trim(json_encode($data));
        exit;
    }
}
