<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class GroupNumberValidator extends AbstractValidator
{

   protected string $message = 'Field :field must contain exactly 3 digits';

   public function rule(): bool
   {
       $value = $this->value;
       // Проверка на то, что значение содержит ровно 3 цифры
       return (bool) preg_match('/^\d{3}$/', $value);
   }
}