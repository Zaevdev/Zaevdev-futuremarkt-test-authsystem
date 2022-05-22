<?php

namespace app\core\form;

use app\core\ValidationModel;

class Form
{
    public array $errors = [];

    public static function begin($action, $method): Form
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);

        return new self();
    }

    public function end(): string
    {
        return "</form>";
    }

    public function field(ValidationModel $model, $attribute): void
    {
        $field = new Field($model, $attribute);
        echo $field->__toString();
    }
}
