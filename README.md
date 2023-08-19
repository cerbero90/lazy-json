# 🐼 Lazy JSON

[![Author][ico-author]][link-author]
[![PHP Version][ico-php]][link-php]
[![Build Status][ico-actions]][link-actions]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![PHPStan Level][ico-phpstan]][link-phpstan]
[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![PER][ico-per]][link-per]
[![Total Downloads][ico-downloads]][link-downloads]

```php
LazyCollection::fromJson($source, 'data.*.users.*')
    ->map($this->mapToUser(...))
    ->filter($this->filterUser(...))
    ->values()
    ->chunk(1_000)
    ->each($this->storeUsersChunk(...));
```

Framework-agnostic package to load JSON of any size and from any source into [Laravel lazy collections](https://laravel.com/docs/collections#lazy-collections).

Lazy JSON recursively turns any JSON array and object into a lazy collection, consuming only a few KB of memory while parsing JSON of any dimension.

It optionally allows to extract only some sub-trees, instead of the whole JSON, with an easy dot-notation syntax.

Under the hood, [🧩 JSON Parser](https://github.com/cerbero90/json-parser) is used to parse JSONs and extract sub-trees.

Need to lazy load items from paginated JSON APIs? Consider using [🐼 Lazy JSON Pages](https://github.com/cerbero90/lazy-json-pages) instead.


## 📦 Install

Via Composer:

``` bash
composer require cerbero/lazy-json
```

## 🔮 Usage

* [👣 Basics](#-basics)
* [💧 Sources](#-sources)
* [🎯 Dots](#-dots)


### 👣 Basics

Depending on our coding style, we can call Lazy JSON in 3 different ways:

```php
use Cerbero\LazyJson\LazyJson;
use Illuminate\Support\LazyCollection;

use function Cerbero\LazyJson\lazyJson;

// auto-registered lazy collection macro
$lazyCollection = LazyCollection::fromJson($source);

// static method
$lazyCollection = LazyJson::from($source);

// namespaced helper
$lazyCollection = lazyJson($source);
```

Once the [JSON source](#-sources) is set, we can chain any method of the [Laravel lazy collection](https://laravel.com/docs/collections#lazy-collections) to process the JSON in a memory-efficient way:

```php
LazyCollection::fromJson($source)
    ->map(/* ... */)
    ->where(/* ... */)
    ->each(/* ... */);
```


### 💧 Sources

A JSON source is any data point that provides a JSON. A wide range of sources are supported by default:
- **strings**, e.g. `{"foo":"bar"}`
- **iterables**, i.e. arrays or instances of `Traversable`
- **file paths**, e.g. `/path/to/large.json`
- **resources**, e.g. streams
- **API endpoint URLs**, e.g. `https://endpoint.json` or any instance of `Psr\Http\Message\UriInterface`
- **PSR-7 requests**, i.e. any instance of `Psr\Http\Message\RequestInterface`
- **PSR-7 messages**, i.e. any instance of `Psr\Http\Message\MessageInterface`
- **PSR-7 streams**, i.e. any instance of `Psr\Http\Message\StreamInterface`
- **Laravel HTTP client requests**, i.e. any instance of `Illuminate\Http\Client\Request`
- **Laravel HTTP client responses**, i.e. any instance of `Illuminate\Http\Client\Response`
- **user-defined sources**, i.e. any instance of `Cerbero\JsonParser\Sources\Source`

For more information about JSON sources, please consult the [🧩 JSON Parser documentation](https://github.com/cerbero90/json-parser).


### 🎯 Dots

If we only need a sub-tree of a large JSON, we can use a simple dot-notation syntax to extract the desired path (or **dot**).

Consider [this JSON](https://randomuser.me/api/1.4?seed=json-parser&results=5) for example. To extract only the cities and avoid parsing the rest of the JSON, we can set the `results.*.location.city` dot:

```php
$source = 'https://randomuser.me/api/1.4?seed=json-parser&results=5';

LazyCollection::fromJson($source, 'results.*.location.city')->each(function (string $value, string $key) {
    // 1st iteration: $key === 'city', $value === 'Sontra'
    // 2nd iteration: $key === 'city', $value === 'San Rafael Tlanalapan'
    // 3rd iteration: $key === 'city', $value === 'گرگان'
    // ...
});
```

The dot-notation syntax is very simple and it can include any of the following 3 elements:
- a key of a JSON object, e.g. `results`
- an asterisk to indicate all items within an array, e.g. `results.*`
- a dot to indicate the nesting level within a JSON, e.g. `results.*.location`

## 📆 Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## 🧪 Testing

``` bash
composer test
```

## 💞 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## 🧯 Security

If you discover any security related issues, please email andrea.marco.sartori@gmail.com instead of using the issue tracker.

## 🏅 Credits

- [Andrea Marco Sartori][link-author]
- [All Contributors][link-contributors]

## ⚖️ License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-author]: https://img.shields.io/static/v1?label=author&message=cerbero90&color=50ABF1&logo=twitter&style=flat-square
[ico-php]: https://img.shields.io/packagist/php-v/cerbero/lazy-json?color=%234F5B93&logo=php&style=flat-square
[ico-version]: https://img.shields.io/packagist/v/cerbero/lazy-json.svg?label=version&style=flat-square
[ico-actions]: https://img.shields.io/github/actions/workflow/status/cerbero90/json-parser/build.yml?branch=master&style=flat-square&logo=github
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-per]: https://img.shields.io/static/v1?label=compliance&message=PER&color=blue&style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/cerbero90/lazy-json.svg?style=flat-square&logo=scrutinizer
[ico-code-quality]: https://img.shields.io/scrutinizer/g/cerbero90/lazy-json.svg?style=flat-square&logo=scrutinizer
[ico-phpstan]: https://img.shields.io/badge/level-max-success?style=flat-square&logo=data:image/png;base64,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
[ico-downloads]: https://img.shields.io/packagist/dt/cerbero/lazy-json.svg?style=flat-square

[link-author]: https://twitter.com/cerbero90
[link-php]: https://www.php.net
[link-packagist]: https://packagist.org/packages/cerbero/lazy-json
[link-actions]: https://github.com/cerbero90/lazy-json/actions?query=workflow%3Abuild
[link-per]: https://www.php-fig.org/per/coding-style/
[link-scrutinizer]: https://scrutinizer-ci.com/g/cerbero90/lazy-json/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/cerbero90/lazy-json
[link-downloads]: https://packagist.org/packages/cerbero/lazy-json
[link-phpstan]: https://phpstan.org/
[link-contributors]: ../../contributors
