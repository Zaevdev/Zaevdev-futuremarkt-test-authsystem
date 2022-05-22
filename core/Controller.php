<?php

namespace app\core;

class Controller 
{

    public static function render($view, $params = [], $layout = "main"): string
    {
        return Application::$app->router->render($view, $layout, $params);
    }

    public function getLogOut(): void
    {
        Application::$app->logout();
    }
}