<?php

namespace FDevs\Bridge\Locale\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class DuplicateLocale extends Constraint
{
    public $message = 'Locale "%locale%" is duplicate.';
}
