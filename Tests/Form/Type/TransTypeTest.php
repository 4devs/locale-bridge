<?php

namespace FDevs\Bridge\Locale\Tests\Form\Type;

use FDevs\Bridge\Locale\Form\Type\LocaleText\HiddenLocaleType as LocaleTextType;
use FDevs\Locale\Model\LocaleText;
use FDevs\Bridge\Locale\Tests\AbstractTest;
use Symfony\Component\Form\Test\TypeTestCase;

abstract class TransTypeTest extends TypeTestCase
{
    /**
     * @return string
     */
    abstract protected function getFormType();

    /**
     * @dataProvider getValidTestData
     * @test
     */
    public function shouldSubmitValidData($formData, $langCode, $localeType)
    {
        $form = $this->factory->create($this->getFormType(), null, [
            'locales' => $langCode,
            'locale_type' => $localeType,
        ]);

        $result = [];
        foreach ($formData as $data) {
            $result[] = AbstractTest::fromArray(LocaleText::class, $data);
        }

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertInternalType('array', $form->getData());
        $this->assertEquals($result, $form->getData());

        $view = $form->createView();
        $children = $view->children;
        foreach ($formData as $key => $value) {
            $this->assertArrayHasKey($key, $children);
            if ($child = $children[$key]->children) {
                foreach (array_keys($value) as $key) {
                    $this->assertArrayHasKey($key, $child);
                }
            }
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
                    [
                        'locale' => 'en',
                        'text' => 'test2',
                    ],
                ],
                'langCode' => ['en'],
                'localeType' => LocaleTextType::class,
            ],
            [
                'data' => [
                    [
                        'locale' => 'en',
                        'text' => 'test en',
                    ],
                    [
                        'locale' => 'ru',
                        'text' => 'test ru',
                    ],
                ],
                'langCode' => ['en', 'ru'],
                'localeType' => LocaleTextType::class,
            ],
            [
                'data' => [
                    [
                        'locale' => 'en',
                        'text' => 'test en',
                    ],
                    [
                        'locale' => 'ru',
                        'text' => 'test ru',
                    ],
                    [
                        'locale' => 'uk',
                        'text' => 'test uk',
                    ],
                ],
                'langCode' => ['en', 'ru', 'uk'],
                'localeType' => LocaleTextType::class,
            ],
        ];
    }
}
