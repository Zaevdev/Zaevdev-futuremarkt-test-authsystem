<?php

namespace app\core\form;

use app\core\ValidationModel;

class Field
{

    public ValidationModel $model;
    public string $attribute = "";

    public function __construct(ValidationModel $model, $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf(
            '<div class="mb-3">
        <label class="form-label" >%s</label>
        <input type="%s" name="%s" value="%s" class="form-control %s">
        <div class="invalid-feedback">%s</div>
        </div>',
            $this->labels()[$this->attribute],
            $this->checkType(),
            $this->attribute,
            $this->model->{$this->attribute},
            $this->hasError() ? "is-invalid" : false,
            $this->getFirstError(),
        );
    }

    public function hasError()
    {
        return $this->model->errors[$this->attribute] ?? false;
    }

    public function getFirstError()
    {
        return $this->model->errors[$this->attribute][0] ?? false;
    }

    public function labels(): array
    {
        return [
            "firstname" => "First name",
            "lastname" => "Last name",
            "email" => "Email",
            "password" => "Password",
            "passwordConfirm" => "Confirm Password"
        ];
    }

    public function checkType(): string
    {
        return $this->attribute === "password" || $this->attribute === "passwordConfirm" ? "password" : "text";
    }

    public function getSome($attribute): ValidationModel
    {
        return $this->model;
    }
}
