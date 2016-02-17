Use with Symfony [Validation](https://github.com/symfony/validator)
=======================

###DuplicateLocale
checks the collection to the uniqueness of the locale

####add validation

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<constraint-mapping xmlns="http://symfony.com/schema/dic/constraint-mapping"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xsi:schemaLocation="http://symfony.com/schema/dic/constraint-mapping http://symfony.com/schema/dic/constraint-mapping/constraint-mapping-1.0.xsd">

    <class name="App\Model\Article">
        <property name="post">
            <constraint name="FDevs\Locale\Validator\Constraints\DuplicateLocale" />
        </property>
    </class>

</constraint-mapping>
```

###usage

```php
$validator = /** init validate **/
$violations = $validator->validate($article);
```

