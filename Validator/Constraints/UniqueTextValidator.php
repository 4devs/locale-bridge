<?php

namespace FDevs\Bridge\Locale\Validator\Constraints;

use Doctrine\Common\Persistence\ManagerRegistry;
use FDevs\Locale\LocaleTextInterface;
use Symfony\Component\Intl\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class UniqueTextValidator extends ConstraintValidator
{
    /** @var ManagerRegistry */
    private $registry;

    /**
     * init.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $class = $this->context->getClassName();
        $manager = $this->registry->getManagerForClass($class);
        $field = $this->context->getPropertyName();
        if (!$manager) {
            throw new ConstraintDefinitionException(sprintf('Unable to find the object manager associated with an object of class "%s".', $class));
        }

        foreach ($value as $key => $locale) {
            if (!$locale instanceof LocaleTextInterface) {
                throw new UnexpectedTypeException($locale, 'FDevs\Locale\LocaleTextInterface');
            }

            $data = $manager->getRepository($class)->findOneBy([$field.'.locale' => $locale->getLocale(), $field.'.text' => $locale->getText()]);
            if ($data) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->setParameter('%value%', $locale->getText())
                    ->setParameter('%locale%', $locale->getLocale())
                    ->addViolation();
            }
        }
    }
}
