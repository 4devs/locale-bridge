Use with Symfony [Form](https://github.com/symfony/form)
=======================

### Use model FDevs\Locale\Model\LocaleText

#### required locales

each language needs to be added

``` php
use FDevs\Bridge\Locale\Form\Type\LocaleText\TransTextareaType;
use FDevs\Bridge\Locale\Form\Type\LocaleText\TransTextType;

// ... init formFactory

$form = $formFactory->createBuilder()
    ->add('task', TransTextareaType::class)
    ->add('post', TransTextType::class)
    ->getForm();

```

#### not mandatory Locales

``` php
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FDevs\Bridge\Locale\Form\Type\LocaleText\TransTextType;
use FDevs\Bridge\Locale\Form\Type\LocaleText\ChoiceLocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

// ... init formFactory

$form = $formFactory->createBuilder()
    ->add('post', CollectionType::class, [
        /** other options **/
        'entry_type' => ChoiceLocaleType::class,
        'options' => [
            'type' => TextareaType::class,
            'lang_code' => $locales,
        ],
    ])
    ->add('task', CollectionType::class, [
        /** other options **/
        'entry_type' => ChoiceLocaleType::class,
        'options' => [
            'type' => TextType::class,
            'lang_code' => $locales,
        ],
    ])
    ->getForm();
```

### Use different model

#### create Model

``` php
<?php

namespace FDevs\ArticleBundle\Model;

use FDevs\Locale\LocaleInterface;
use FDevs\Locale\LocaleTrait;

class Post implements LocaleInterface
{
    use LocaleTrait;

    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var string */
    protected $text;
    
//....
}
```

#### create form

##### not mandatory locales
 
``` php
<?php

namespace FDevs\ArticleBundle\Form\Type;

use FDevs\Bridge\Locale\Form\Type\ChoiceLocaleType;
use FDevs\ArticleBundle\Model\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextaType::class)
            ->add('description', TextareaType::class)
            ->add('text', TextareaType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Post::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceLocaleType::class;
    }
}
```

##### required locales

``` php
<?php

namespace FDevs\ArticleBundle\Form\Type;

use FDevs\Bridge\Locale\Form\Type\HiddenLocaleType;
use FDevs\ArticleBundle\Model\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextaType::class)
            ->add('description', TextareaType::class)
            ->add('text', TextareaType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Post::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return HiddenLocaleType::class;
    }
}
```

#### use form

##### required locales

``` php
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FDevs\ArticleBundle\Form\Type\PostType;
use FDevs\Bridge\Locale\Form\Type\TransType;


// ... init formFactory

$form = $formFactory->createBuilder()
    ->add('post', TransType::class, [
        /** other options **/
        'locale_type' => PostType::class,
        'locales' => $locales,
    ])
    ->getForm();
```

##### not mandatory locales

``` php
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FDevs\ArticleBundle\Form\Type\PostType;

// ... init formFactory

$form = $formFactory->createBuilder()
    ->add('post', CollectionType::class, [
        /** other options **/
        'entry_type' => PostType::class,
        'options' => [
            'lang_code' => $locales,
        ],
    ])
    ->getForm();
```
