<?php

namespace FDevs\Bridge\Locale\Form\Type\LocaleText;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FDevs\Locale\Model\LocaleText;

class BaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', $options['type'], $options['options']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined(['type'])
            ->addAllowedTypes('type', ['string', FormTypeInterface::class])
            ->setDefaults([
                'data_class' => LocaleText::class,
                'type' => TextType::class,
            ])
        ;
    }
}
