<?php

namespace FDevs\Bridge\Locale\Form\Type\LocaleText;

use FDevs\Bridge\Locale\Form\Type\ChoiceLocaleType as LocaleType;

class ChoiceLocaleType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return LocaleType::class;
    }
}
