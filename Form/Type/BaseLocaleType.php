<?php

namespace FDevs\Bridge\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseLocaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['lang_code'])
            ->setDefaults([
                'compound' => true,
                'options' => [
                    'label' => false,
                    'data_class' => null,
                    'compound' => false,
                    'required' => true,
                    'mapped' => true,
                    'by_reference' => true,
                    'trim' => true,
                ],
            ])
            ->addAllowedTypes('options', ['array'])
        ;
    }
}
