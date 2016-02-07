<?php

namespace FDevs\Bridge\Locale\Validator\Constraints;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\LocaleInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DuplicateLocaleValidator extends ConstraintValidator
{
    /** @var array */
    private $locale = [];

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value instanceof Collection) {
            foreach ($value as $key => $data) {
                if ($data instanceof LocaleInterface) {
                    $locale = $data->getLocale();
                    if (isset($this->locale[$locale])) {
                        $this->context
                            ->buildViolation($constraint->message)
                            ->atPath('['.$key.'].locale')
                            ->setParameter('%locale%', $locale)
                            ->addViolation();
                    }
                    $this->locale[$locale] = true;
                }
            }
        }
    }
}
