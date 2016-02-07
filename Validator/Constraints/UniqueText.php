<?php

namespace FDevs\Bridge\Locale\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueText extends Constraint
{
    /** @var string */
    public $message = "This value '%value%' with locale '%locale%' is already used.";

    /** @var string */
    public $service = 'f_devs_locale.validator.unique_text';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return $this->service;
    }
}
