<?php

namespace FDevs\Bridge\Locale\Tests\Form\Type\LocaleText;

use FDevs\Locale\Model\LocaleText;
use Symfony\Component\Form\Test\TypeTestCase;
use FDevs\Bridge\Locale\Tests\AbstractTest;
use FDevs\Bridge\Locale\Form\Type\LocaleText\HiddenLocaleType as LocaleTextType;

class HiddenLocaleTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData($formData, $langCode)
    {
        $form = $this->factory->create(LocaleTextType::class, null, ['lang_code' => $langCode]);

        $object = AbstractTest::fromArray(LocaleText::class, $formData);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    /**
     * @return array
     */
    public function getValidTestData()
    {
        return [
            [
                'data' => [
                    'locale' => 'en',
                    'text' => 'test2',
                ],
                'langCode' => 'en',
            ],
            [
                'data' => [
                    'locale' => 'ru',
                    'text' => 'test2',
                ],
                'langCode' => 'ru',
            ],
            [
                'data' => [
                    'locale' => 'en',
                    'text' => '',
                ],
                'langCode' => 'en',
            ],
            [
                'data' => [],
                'langCode' => 'en',
            ],
            [
                'data' => [
                    'locale' => 'en',
                    'text' => null,
                ],
                'langCode' => 'en',
            ],
        ];
    }
}
