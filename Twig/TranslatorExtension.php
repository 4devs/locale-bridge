<?php

namespace FDevs\Bridge\Locale\Twig;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\TranslatorInterface;
use FDevs\Locale\LocaleInterface;

class TranslatorExtension extends \Twig_Extension
{
    /** @var array */
    private $twigExtensions = [];

    /** @var TranslatorInterface */
    private $translator;

    /** @var \Twig_Environment */
    private $environment;

    /**
     * init.
     *
     * @param TranslatorInterface $translator
     * @param array               $twigExtensions
     */
    public function __construct(TranslatorInterface $translator, array $twigExtensions = [])
    {
        $this->twigExtensions = $twigExtensions;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('tt', [$this, 'transText'], ['is_safe' => ['html'], 'needs_environment' => true]),
            new \Twig_SimpleFilter('tc', [$this, 'translationCollection'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'locale_translator_extension';
    }

    /**
     * @param \Twig_Environment                         $env
     * @param LocaleInterface[]|array|Collection|string $data
     * @param string                                    $locale
     *
     * @return string
     *
     * @throws \Exception
     */
    public function transText(\Twig_Environment $env, $data, $locale = '')
    {
        if ($data instanceof Collection || is_array($data)) {
            $text = $this->translator->trans($data, $locale);
            $data = '';
            if ($text && method_exists($text, '__toString')) {
                $data = strval($text);
            } elseif (isset($text['text'])) {
                $data = $text['text'];
            }
            if ($data) {
                $data = $this->createTemplate($data, $env)->render([]);
            }
        }

        return $data;
    }

    /**
     * @param LocaleInterface[]|Collection|array $data
     * @param string                             $locale
     *
     * @return LocaleInterface|null
     */
    public function translationCollection($data, $locale = '')
    {
        $trans = null;
        if ($data instanceof Collection || is_array($data)) {
            $trans = $this->translator->trans($data, $locale);
        }

        return $trans;
    }

    /**
     * create template.
     *
     * @param string            $text
     * @param \Twig_Environment $env
     *
     * @return \Twig_Template
     */
    private function createTemplate($text, \Twig_Environment $env)
    {
        if (!$this->environment) {
            $this->environment = new \Twig_Environment($env->getLoader());
            foreach ($this->twigExtensions as $ext) {
                if (!$ext instanceof \Twig_ExtensionInterface) {
                    $ext = $env->getExtension($ext);
                }
                $this->environment->addExtension($ext);
            }
        }

        return $this->environment->createTemplate($text);
    }
}
