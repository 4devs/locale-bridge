<?php

namespace FDevs\Bridge\Locale\Form\Type;

use FDevs\Bridge\Locale\Form\EventListener\TranslatableFormSubscriber;
use FDevs\Locale\LocaleInterface;
use FDevs\Locale\Model\LocaleText;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransType extends AbstractType
{
    /**
     * @var array
     */
    private $locales;

    /**
     * TransType constructor.
     *
     * @param array $locales
     */
    public function __construct(array $locales = ['en'])
    {
        $this->setLocales($locales);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new TranslatableFormSubscriber($options['locale_type'], $options['options'], $options['locales']));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['block_locale'] = $options['block_locale'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['locale_type'])
            ->setDefaults([
                'locale_type' => HiddenLocaleType::class,
                'options' => [],
                'block_locale' => 'inline',
                'locales' => $this->locales,
                'data_class' => LocaleText::class,
            ])
            ->setDefined(['locales', 'options', 'block_locale'])
            ->addAllowedTypes('locales', 'array')
            ->addAllowedTypes('options', 'array')
            ->addAllowedTypes('locale_type', ['string', FormTypeInterface::class])
            ->addAllowedTypes('block_locale', ['string'])
            ->setAllowedValues('data', [LocaleInterface::class])
            ->setNormalizer('block_locale', function ($options, $value) {
                return 'fdevs_locale_'.$value;
            })
        ;
    }

    /**
     * set Locales.
     *
     * @param array $locales
     *
     * @return $this
     */
    public function setLocales(array $locales)
    {
        $this->locales = $locales;

        return $this;
    }
}
