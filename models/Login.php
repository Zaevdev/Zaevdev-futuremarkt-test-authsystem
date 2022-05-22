<?php

namespace app\models;

use app\core\Application;
use app\core\DbValidationModel;
use JetBrains\PhpStorm\ArrayShape;

class Login extends DbValidationModel
{
    public string $email = "";

    public string $password = "";

    public function getAttributes(): array
    {
        return ["email", "password"];
    }

    #[ArrayShape(["email" => "array", "password" => "array"])]
    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, [self::RULE_EMAIL], [self::RULE_INVALID_EMAIL]],
            "password" => [self::RULE_REQUIRED, [self::RULE_INCORRECT]]
        ];
    }

    public function validate(): bool
    {
        $user = User::findOne(["email" => $this->email]);
        if ($user === false) {
            $this->addErrors("email", self::RULE_INVALID_EMAIL);

            return false;
        }

        if (!password_verify($this->password, $user->password)) {
            $this->addErrors("password", self::RULE_INCORRECT);

            return false;
        }

        return Application::$app->login($user);
    }
}
