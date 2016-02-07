<?php

namespace FDevs\Bridge\Locale\Form\Type\LocaleText;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TransTextareaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TransTextType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'options' => ['type' => TextareaType::class],
                'block_locale' => 'text_tabs',
            ]);
    }
}
