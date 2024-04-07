<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class GenderValidator extends AbstractValidator
{

   protected string $message = 'Field :field must be "M" or "Ж"';

   public function rule(): bool
   {
       $value = $this->value;
       // Проверка на соответствие значению "M" или "Ж"
       return $value === 'М' || $value === 'Ж';
   }
}
