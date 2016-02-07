<?php

namespace FDevs\Bridge\Locale\Tests\Form\Type;

use FDevs\Bridge\Locale\Form\Type\LocaleText\TransTextType;

class TransTextTypeTest extends TransTypeTest
{
    /**
     * {@inheritdoc}
     */
    protected function getFormType()
    {
        return TransTextType::class;
    }
}
