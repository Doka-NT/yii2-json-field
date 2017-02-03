Yii2 JSON Field
===============
Help you to define fields, that can contains json. Json in this fields would be automatically serialized and deserialized

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require skobka/yii2-json-field
```

or add

```
"skobka/yii2-json-field": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php

### Product.php

/**
 * @property object|array|null $field1  
 */
class Product extends AvtiveRecord {
   use JsonFieldTrait;
   
   public function behaviors()
   {
        return [
            'field1' => [
                'class' => JsonFieldBehavior::class,
                'dataField' => 'json_field_1', // this is the name of field in db table
            ],
        ];
   }
}

### ProductController.php
// saving 
$product = Product::findOne(['id' => 1]);

$product->field1 = new \StdClass();
$product->field1->foo = 'bar';
$product->save();

$product = Product::findOne(['id' => 1]);
print $product->field1->foo; // bar
```
