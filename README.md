# Lazy JSON

[![Author][ico-author]][link-author]
[![PHP Version][ico-php]][link-php]
[![Laravel Version][ico-laravel]][link-laravel]
[![Octane Compatibility][ico-octane]][link-octane]
[![Build Status][ico-actions]][link-actions]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![PSR-7][ico-psr7]][link-psr7]
[![PSR-12][ico-psr12]][link-psr12]
[![Total Downloads][ico-downloads]][link-downloads]

Framework agnostic package to load heavy JSON in [lazy collections](https://laravel.com/docs/collections#lazy-collections). Under the hood, the brilliant [JSON Machine](https://github.com/halaxa/json-machine) by [@halaxa](https://github.com/halaxa) is used as lexer and parser.


## Install

In a Laravel application, all you need to do is requiring the package:

``` bash
composer require cerbero/lazy-json
```

Otherwise, you also need to register the lazy collection macro manually:

```php
use Cerbero\LazyJson\Macro;
use Illuminate\Support\LazyCollection;

LazyCollection::macro('fromJson', new Macro());
```

## Usage

Loading JSON in lazy collections is possible by using the collection itself or the included helper:

```php
LazyCollection::fromJson($source);

lazyJson($source);
```

The following are the supported JSON sources:

```php
$source = '{"foo":"bar"}'; // JSON string
$source = ['{"foo":"bar"}']; // any iterable containing JSON, i.e. array or Traversable
$source = 'https://foo.test/endpoint'; // endpoint
$source = Http::get('https://foo.test/endpoint'); // Laravel HTTP client response
$source = '/path/to/file.json'; // JSON file
$source = fopen('/path/to/file.json', 'rb'); // any resource
$source = <Psr\Http\Message\MessageInterface>; // any PSR-7 message, e.g. Guzzle response
$source = <Psr\Http\Message\StreamInterface>; // any PSR-7 stream
```

Optionally, you can define a dot-noted path to extract only a sub-tree of the JSON. For example, given the following JSON:

```json
{
    "data": [
        {
            "name": "Team 1",
            "users": [
                {
                    "id": 1
                },
                {
                    "id": 2
                }
            ]
        },
        {
            "name": "Team 2",
            "users": [
                {
                    "id": 3
                }
            ]
        }
    ]
}
```

defining the path `data.*.users.*.id` would iterate only user IDs:

```php
lazyJson($source, 'data.*.users.*.id')
    ->filter(fn ($id) => $id % 2 == 0)
    ->all();
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email andrea.marco.sartori@gmail.com instead of using the issue tracker.

## Credits

- [Andrea Marco Sartori][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-author]: https://img.shields.io/static/v1?label=author&message=cerbero90&color=50ABF1&logo=twitter&style=flat-square
[ico-php]: https://img.shields.io/packagist/php-v/cerbero/lazy-json?color=%234F5B93&logo=php&style=flat-square
[ico-laravel]: https://img.shields.io/static/v1?label=laravel&message=%E2%89%A56.0&color=ff2d20&logo=laravel&style=flat-square
[ico-octane]: https://img.shields.io/static/v1?label=octane&message=compatible&color=ff2d20&logo=laravel&style=flat-square
[ico-version]: https://img.shields.io/packagist/v/cerbero/lazy-json.svg?label=version&style=flat-square
[ico-actions]: https://img.shields.io/github/workflow/status/cerbero90/lazy-json/build?style=flat-square&logo=github
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-psr7]: https://img.shields.io/static/v1?label=compliance&message=PSR-7&color=blue&style=flat-square
[ico-psr12]: https://img.shields.io/static/v1?label=compliance&message=PSR-12&color=blue&style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/cerbero90/lazy-json.svg?style=flat-square&logo=scrutinizer
[ico-code-quality]: https://img.shields.io/scrutinizer/g/cerbero90/lazy-json.svg?style=flat-square&logo=scrutinizer
[ico-downloads]: https://img.shields.io/packagist/dt/cerbero/lazy-json.svg?style=flat-square

[link-author]: https://twitter.com/cerbero90
[link-php]: https://www.php.net
[link-laravel]: https://laravel.com
[link-octane]: https://github.com/laravel/octane
[link-packagist]: https://packagist.org/packages/cerbero/lazy-json
[link-actions]: https://github.com/cerbero90/lazy-json/actions?query=workflow%3Abuild
[link-psr7]: https://www.php-fig.org/psr/psr-7/
[link-psr12]: https://www.php-fig.org/psr/psr-12/
[link-scrutinizer]: https://scrutinizer-ci.com/g/cerbero90/lazy-json/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/cerbero90/lazy-json
[link-downloads]: https://packagist.org/packages/cerbero/lazy-json
[link-contributors]: ../../contributors
