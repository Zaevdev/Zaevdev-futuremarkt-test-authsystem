<?php

namespace app\core;

use JetBrains\PhpStorm\ArrayShape;

abstract class ValidationModel
{
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";
    public const RULE_INVALID_EMAIL = "invalid_mail";
    public const RULE_INCORRECT = "incorrect";
    public array $errors = [];

    protected static string $tableName = "users";

    public function loadData($data, object $object): void
    {
        $object = new $object();
        foreach ($data as $key => $value) {
            if (property_exists($object, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules();

    abstract protected static function prepare($sql);

    abstract protected function validate();

    public function addErrors($attribute, $ruleName, $params = []): void
    {
        $message = $this->errorMessages()[$ruleName];
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    #[ArrayShape([
        self::RULE_REQUIRED => "string",
        self::RULE_EMAIL => "string",
        self::RULE_MIN => "string",
        self::RULE_MAX => "string",
        self::RULE_MATCH => "string",
        self::RULE_UNIQUE => "string",
        self::RULE_INVALID_EMAIL => "string",
        self::RULE_INCORRECT => "string"
    ])]
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => "This field is required!",
            self::RULE_EMAIL => "This Email is invalid!",
            self::RULE_MIN => 'This field length must be minimum {min}!',
            self::RULE_MAX => "This field length must be maximum {max}!",
            self::RULE_MATCH => "This field must be same as Password!",
            self::RULE_UNIQUE => "This Email is already exist!",
            self::RULE_INVALID_EMAIL => "This Email does not exist!",
            self::RULE_INCORRECT => "This Password is incorrect!"
        ];
    }
}
