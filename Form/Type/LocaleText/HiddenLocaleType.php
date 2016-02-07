<?php

namespace FDevs\Bridge\Locale\Form\Type\LocaleText;

use FDevs\Bridge\Locale\Form\Type\HiddenLocaleType as LocaleType;

class HiddenLocaleType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return LocaleType::class;
    }
}
