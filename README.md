Modal CRUD Gii templates for Yii2 framework
=================

## Description

This generator generates a controller and views that implement CRUD (Create, Read, Update, Delete)
operations for the specified data model. 

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). 

To install, either run

```
$ php composer.phar require conquer/gii-modal "*"
```
or add

```
"conquer/gii-modal": "*"
```

to the ```require``` section of your `composer.json` file.

## Usage

Add to config file:

```php
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',      
        'allowedIPs' => ['127.0.0.1', '::1'],  
        'generators' => [
            'modal_crud' => [ // generator name
                'class' => 'conquer\gii\templates\crud\Generator', // generator class
            ]
        ],
    ]; 
}
```

## License

**conquer/gii-modal** is released under the MIT License. See the bundled `LICENSE.md` for details.
