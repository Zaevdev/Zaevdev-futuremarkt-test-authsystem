<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\services\client\BinanceClient;

class CryptoController extends Controller
{

    public function crypto(Request $request)
    {
        if (Application::$app->isGuest()) {
            $request->redirect("login");
            exit;
        }

        return self::render("/crypto", [
            'valutes' => BinanceClient::getCurrencyRate(),
        ]);
    }
}
