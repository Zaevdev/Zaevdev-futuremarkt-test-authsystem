<?php

namespace app\controllers;

use app\core\Controller;

class SiteController extends Controller
{
    public static function goHome(): string
    {
        return self::render("home");
    }
}
