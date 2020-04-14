# (Temporary package) Migrate code to package: Everything Else

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
<!--
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
-->
[![Quality Score][ico-code-quality]][link-code-quality]
<!--
[![Total Downloads][ico-downloads]][link-downloads]
-->

Code to be migrated, from legacy PHP 5 code to modern PHP 7 code ([read more here](https://github.com/leoloso/PoP#codebase-migration)). Target package description:  Adds support for meta queries

## Install

Via Composer

``` bash
composer require getpop/migrate-everythingelse
```

<!--
## Usage

``` php
```
-->

## Standards

[PSR-1](https://www.php-fig.org/psr/psr-1), [PSR-4](https://www.php-fig.org/psr/psr-4) and [PSR-12](https://www.php-fig.org/psr/psr-12).

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
composer test
```

## Static Analysis

Execute [phpstan](https://github.com/phpstan/phpstan) with level 8 (strictest mode):

``` bash
composer analyse
```

To run checks for level 0 (or any level from 0 to 8):

``` bash
./vendor/bin/phpstan analyse -l 0 src tests
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email leo@getpop.org instead of using the issue tracker.

## Credits

- [Leonardo Losoviz][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/getpop/everythingelse.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/getpop/everythingelse/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/getpop/everythingelse.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/getpop/everythingelse.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/getpop/everythingelse.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/getpop/everythingelse
[link-travis]: https://travis-ci.org/getpop/everythingelse
[link-scrutinizer]: https://scrutinizer-ci.com/g/getpop/everythingelse/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/getpop/everythingelse
[link-downloads]: https://packagist.org/packages/getpop/everythingelse
[link-author]: https://github.com/leoloso
[link-contributors]: ../../contributors
