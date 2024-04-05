<?php
namespace Validators;

use Src\Validator\AbstractValidator;

class UppercaseValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать только заглавные буквы';

    public function rule(): bool
    {
        return $this->value === mb_strtoupper($this->value, 'UTF-8');
    }
}