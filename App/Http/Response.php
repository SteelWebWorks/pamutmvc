<?php

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

    public function json(array $data): true
    {
        echo trim(json_encode($data));
        return true;
    }
}
