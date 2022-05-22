<?php

namespace app\core;

use PDOStatement;

abstract class DbValidationModel extends ValidationModel
{
    abstract protected function getAttributes();

    protected static string $tableName = 'users';

    public function save(): void
    {
        $table = self::$tableName;
        $attributes = implode(", ", $this->getAttributes());
        $values = implode(", ", array_map(static fn($a) => ":$a", $this->getAttributes()));
        $statement = self::prepare("INSERT INTO $table ($attributes) VALUES ($values)");

        foreach ($this->getAttributes() as $attribute) {
            $statement->bindValue(":$attribute", $this->hashPassword($attribute, $this->{$attribute}));
        }
        $statement->execute();
    }

    protected static function prepare($sql): bool|PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    protected function hashPassword($attribute, $value): string
    {
        return ($attribute === "password") ? password_hash($value, PASSWORD_BCRYPT) : $value;
    }

    public static function findOne($data)
    {
        $table = self::$tableName;
        $attributes = implode(", ", array_keys($data));
        $statement = self::prepare("SELECT * FROM  $table WHERE $attributes = :$attributes");
        foreach ($data as $attribute => $value) {
            $statement->bindValue(":$attribute", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}
