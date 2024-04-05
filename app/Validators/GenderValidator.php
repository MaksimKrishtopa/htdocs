<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class GenderValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать только буквы М или Ж';

    public function rule(): bool
    {
        return preg_match('/^[МЖ]$/ui', $this->value);
    }
}