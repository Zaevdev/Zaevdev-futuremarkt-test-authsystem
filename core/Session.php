<?php

namespace app\core;

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get($key): ?string
    {
        return $_SESSION[$key] ?? null;
    }

    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }
}
