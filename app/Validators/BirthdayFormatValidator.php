<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class BirthdayFormatValidator extends AbstractValidator
{

   protected string $message = 'Field :field must be in format "YYYY.MM.DD"';

   public function rule(): bool
   {
       $value = $this->value;
       // Проверка на соответствие формату "YYYY-MM-DD"
       return (bool) preg_match('/^\d{4}-\d{2}-\d{2}$/', $value);
   }
}