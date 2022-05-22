<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Login;
use app\models\User;
use app\services\auth\AuthService;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Application::$app->isGuest()) {
            $login = new Login();

            if (AuthService::isPostMethod($request, $login)) {
                $request->redirect("/crypto");
                exit;
            }

            return self::render("login", [
                "model" => $login
            ], "auth");
        }
        $request->redirect("/");
        exit;
    }

    public function register(Request $request)
    {
        if (Application::$app->isGuest()) {
            $user = new User();

            if (AuthService::isPostMethod($request, $user)) {
                $user->save();
                $request->redirect("/login");
                exit;
            }

            return self::render("register", [
                "model" => $user
            ], "auth");
        }
        $request->redirect("/");
        exit;
    }

    #[NoReturn]
    public function logout(Request $request): void
    {
        $this->getLogOut();
        $request->redirect("/");
        exit;
    }
}
