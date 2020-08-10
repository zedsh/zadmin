# 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/ZAdmin.svg?style=flat-square)](https://packagist.org/packages/spatie/ZAdmin)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/ZAdmin/run-tests?label=tests)](https://github.com/spatie/ZAdmin/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/ZAdmin.svg?style=flat-square)](https://packagist.org/packages/spatie/ZAdmin)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

Learn how to create a package like this one, by watching our premium video course:

[![Laravel Package training](https://spatie.be/github/package-training.jpg)](https://laravelpackage.training)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/package-ZAdmin-laravel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="zedsh\zadmin\ZAdminServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="zedsh\zadmin\ZAdminServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$ZAdmin = new zedsh\zadmin();
echo $ZAdmin->echoPhrase('Hello, Zedsh!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Zaboev Eduard](https://github.com/zedsh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
