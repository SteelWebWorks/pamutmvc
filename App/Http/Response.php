<?php

declare(strict_types=1);

namespace App\Http;

class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function json(array $data)
    {
        echo trim(json_encode($data));
        exit;
    }
}
