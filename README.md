# A simple package for creating CMS pages.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lianmaymesi/laravel-cms.svg?style=flat-square)](https://packagist.org/packages/lianmaymesi/laravel-cms)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/lianmaymesi/laravel-cms/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/lianmaymesi/laravel-cms/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/lianmaymesi/laravel-cms/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/lianmaymesi/laravel-cms/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lianmaymesi/laravel-cms.svg?style=flat-square)](https://packagist.org/packages/lianmaymesi/laravel-cms)

Introducing our sleek and content-first Laravel CMS, designed exclusively for me and my company to kickstart projects with unmatched speed and efficiency. Featuring a stunning and intuitive backend admin panel, this CMS is tailored to our unique needs. While it’s currently an internal powerhouse without public installation steps or documentation, it’s crafted to deliver unparalleled ease and functionality for our in-house projects. A tool built for productivity, precision, and style!

## Installation

You can install the package via composer:

```bash
composer require lianmaymesi/laravel-cms
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-cms-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-cms-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-cms-views"
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [lianmaymesi](https://github.com/lianmaymesi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
