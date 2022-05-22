<?php

namespace app\core;

class Request
{
    public function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function getPath(): string
    {
        $path = $_SERVER["REQUEST_URI"];
        $position = strpos($path, "?");
        if ($position) {
            return substr($path, 0, $position);
        }

        return $path;
    }

    public function getBody(): array
    {
        return $_POST;
    }

    public function redirect($url): void
    {
        header("Location: $url");
    }
}
