<?php

namespace app\services\auth;

use app\core\Request;
use app\models\Login;
use app\models\User;

class AuthService
{
    /**
     * @param Request $request
     * @param User|Login $authMethod
     * @return bool
     */
    public static function isPostMethod(Request $request, User|Login $authMethod): bool
    {
        if ($request->getMethod() === "post") {
            $authMethod->loadData($request->getBody(), $authMethod);
            if ($authMethod->validate()) {
                return true;
            }
        }
        return false;
    }
}
