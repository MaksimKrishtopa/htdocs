<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class DateOfBirthValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть в формате гггг.мм.дд';

    public function rule(): bool
    {
        return preg_match('/^\d{4}\.\d{2}\.\d{2}$/', $this->value);
    }
}