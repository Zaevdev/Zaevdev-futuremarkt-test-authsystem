<?php

namespace app\models;

use app\core\Application;
use app\core\DbValidationModel;
use JetBrains\PhpStorm\ArrayShape;

class User extends DbValidationModel
{
    public string $firstname = "";
    public string $lastname = "";
    public string $email = "";
    public string $password = "";
    public string $passwordConfirm = "";

    #[ArrayShape([
        "firstname" => "array",
        "lastname" => "array",
        "email" => "array",
        "password" => "array",
        "passwordConfirm" => "array"
    ])]
    public function rules(): array
    {
        return [
            "firstname" => [self::RULE_REQUIRED],
            "lastname" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, [self::RULE_EMAIL], [self::RULE_UNIQUE],],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 8], [self::RULE_MAX, "max" => 24]],
            "passwordConfirm" => [self::RULE_REQUIRED, [self::RULE_MATCH]]
        ];
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && empty($value)) {
                    $this->addErrors($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrors($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < 8) {
                    $this->addErrors($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule["max"]) {
                    $this->addErrors($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->password) {
                    $this->addErrors($attribute, self::RULE_MATCH);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $table = self::$tableName;
                    $statement = Application::$app->db->pdo->prepare(
                        "SELECT * FROM $table WHERE $attribute = :$attribute"
                    );
                    $statement->bindValue(":$attribute", $this->{$attribute});
                    $statement->execute();
                    $user = $statement->fetchObject();
                    if ($user) {
                        $this->addErrors($attribute, self::RULE_UNIQUE);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    protected function getAttributes(): array
    {
        return [
            "firstname",
            "lastname",
            "email",
            "password"
        ];
    }
}
