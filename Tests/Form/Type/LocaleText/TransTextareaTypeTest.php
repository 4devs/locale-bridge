<?php

namespace FDevs\Bridge\Locale\Tests\Form\Type\LocaleText;

use FDevs\Bridge\Locale\Form\Type\LocaleText\TransTextareaType;
use FDevs\Bridge\Locale\Tests\Form\Type\TransTypeTest;

class TransTextareaTypeTest extends TransTypeTest
{
    /**
     * {@inheritdoc}
     */
    protected function getFormType()
    {
        return TransTextareaType::class;
    }
}
