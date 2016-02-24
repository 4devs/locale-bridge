<?php

namespace FDevs\Bridge\Locale\Form\Type\LocaleText;

use FDevs\Bridge\Locale\Form\Type\TransType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransTextType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TransType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'locale_type' => HiddenLocaleType::class,
        ]);
    }
}
