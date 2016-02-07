Use Mongodb with Symfony [Translation](https://github.com/symfony/Translation)
======================================

## add resource

```php
use Symfony\Component\Translation\Translator;
use FDevs\Bridge\Locale\Translation\Loader\MongodbLoader;

$translator = new Translator('fr_FR');
$translator->addLoader('mongodb', new MongodbLoader());

$mongoBD = new \MongoDB();
$collection = 'fdevs_translation';

$translator->addResource('mongodb', $mongoBD, 'ru', $collection);
$translator->addResource('mongodb', $mongoBD, 'en', $collection);

echo $translator->trans('welcome');
```

## in mongodb

```json
/* 0 */
{
    "_id" : "symfony",
    "trans" : [ 
        {
            "text" : "Symfony is great",
            "locale" : "en"
        }, 
        {
            "text" : "Symfony это здорово",
            "locale" : "ru"
        }
    ]
}
```
