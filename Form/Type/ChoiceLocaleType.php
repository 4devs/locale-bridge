<?php

namespace FDevs\Bridge\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChoiceLocaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $intlBundle = Intl::getLanguageBundle();
        $builder->add('locale', ChoiceType::class, [
            'choices' => $options['lang_code'],
            'choices_as_values' => true,
            'choice_label' => function ($lang) use ($intlBundle) {
                return $intlBundle->getLanguageName($lang);
            },
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->addAllowedTypes('lang_code', ['array']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return BaseLocaleType::class;
    }
}
