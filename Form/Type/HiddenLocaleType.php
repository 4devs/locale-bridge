<?php

namespace FDevs\Bridge\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class HiddenLocaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('locale', HiddenType::class, ['data' => $options['lang_code'], 'empty_data' => $options['lang_code']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->addAllowedTypes('lang_code', ['string']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return BaseLocaleType::class;
    }
}
