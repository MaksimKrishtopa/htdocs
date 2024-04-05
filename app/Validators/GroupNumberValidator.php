<?php
namespace Validators;

use Src\Validator\AbstractValidator;

class GroupNumberValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать только 3 цифры';

    public function rule(): bool
    {
        return preg_match('/^\d{3}$/', $this->value);
    }
}